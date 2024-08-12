<?php

namespace App\Traits;

use App\Models\BookingRequest;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookedRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait ManageBookingRequest
{
    use ManageBooking;

    protected $userType;

    public function index()
    {
        $pageTitle = 'All Booking Request';
        $bookingRequests = $this->bookingRequestData('initial');
        return view($this->userType . '.booking.request_list', compact('pageTitle', 'bookingRequests'));
    }

    public function cancelledBookings()
    {
        $pageTitle = 'Cancelled Booking Request';
        $bookingRequests = $this->bookingRequestData('cancelled');
        return view($this->userType . '.booking.cancelled_requests', compact('pageTitle', 'bookingRequests'));
    }

    public function cancel($id)
    {

        $bookingRequest = BookingRequest::initial()->findOrFail($id);

        $bookingRequest->status = 3;
        $bookingRequest->save();

        notify($bookingRequest->user, 'BOOKING_REQUEST_CANCELLED', [
            'room_type'       => $bookingRequest->roomType->name,
            'number_of_rooms' => $bookingRequest->number_of_rooms,
            'check_in'        => showDateTime($bookingRequest->check_in, 'd M, Y'),
            'check_out'       => showDateTime($bookingRequest->check_out, 'd M, Y')
        ]);

        $notify[] = ['success', 'Booking request cancelled successfully'];
        return back()->with($notify);
    }

    public function approve(Request $request, $id)
    {
        $bookingRequest = BookingRequest::with('user', 'roomType:id,name')->findOrFail($id);
        if ($bookingRequest->status) {
            $notify[] = ['error', 'This booking request already approved'];
            return to_route($this->userType . '.booking.request.all')->withNotify($notify);
        }
        $pageTitle = "Assign Room";

        $request->merge([
            'room_type' => $bookingRequest->room_type_id,
            'rooms' => $bookingRequest->number_of_rooms,
            'checkin_date'  => $bookingRequest->check_in,
            'checkout_date' => $bookingRequest->check_out,
            'unit_fare' => $bookingRequest->unit_fare
        ]);

        $view =  $this->getRooms($request); // getRooms function's definition is in App/Traits/ManageBooking

        return view($this->userType . '.booking.request_approve', compact('pageTitle', 'view', 'bookingRequest'));
    }

    public function assignRoom(Request $request)
    {
        $request->validate([
            'booking_request_id' => 'required|exists:booking_requests,id',
            'room'               => 'required|array'
        ]);

        $bookingRequest = BookingRequest::with('user', 'roomType')->findOrFail($request->booking_request_id);
        $user           = $bookingRequest->user;

        $status = 1;

        $booking                = new Booking();
        $booking->booking_number  = getTrx();
        $booking->user_id       = $user->id;
        $booking->total_amount  = $bookingRequest->total_amount;
        $booking->status        = $status;
        $booking->save();

        $this->bookingActionHistory('approve_booking_request', $booking->id);

        $roomIds = [];

        foreach ($request->room as $room) {
            $roomId                   = explode('-', $room)[0];
            $bookedFor                = explode('-', $room)[1];

            $room                     = Room::with('roomType')->findOrFail($roomId);

            $bookedRoom               = new BookedRoom();
            $bookedRoom->booking_id   = $booking->id;
            $bookedRoom->room_id      = $room->id;
            $bookedRoom->booked_for   = Carbon::parse($bookedFor)->format('Y-m-d');
            $bookedRoom->fare         = $room->roomType->fare;
            $bookedRoom->status       = $status;
            $bookedRoom->save();

            array_push($roomIds, $room->id);
        }

        $bookingRequest->booking_id = $booking->id;
        $bookingRequest->status     = $status;
        $bookingRequest->save();

        $roomNumbers = Room::whereIn('id', $roomIds)->pluck('room_number')->toArray();
        $rooms = implode(" , ", $roomNumbers);

        notify($user, 'ROOM_BOOKED', [
            'booking_number' => $booking->booking_number,
            'amount' => showAmount($booking->total_amount),
            'rooms' => $rooms,
            'check_in' => Carbon::parse($booking->check_in)->format('d M, Y'),
            'check_out' => Carbon::parse($booking->check_out)->format('d M, Y')
        ]);

        $notify[] = ['success', 'Booking Request approved successfully'];
        return redirect()->route($this->userType . '.booking.request.all')->withNotify($notify);
    }

    protected function bookingRequestData($scope)
    {
        $query = BookingRequest::$scope();

        if (request()->search) {
            $search = request()->search;
            $query = $query->whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $query = $query->with('user', 'roomType')->latest()->paginate(getPaginate());
        return $query;
    }
}
