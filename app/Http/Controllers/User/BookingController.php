<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use App\Models\Booking;


class BookingController extends Controller
{

    public function allBookings()
    {
        $pageTitle = 'Booking History';
        $bookings = Booking::where('user_id', auth()->id())->withMin('bookedRoom', 'booked_for')
            ->withMax('bookedRoom', 'booked_for')
            ->withSum('usedExtraService', 'total_amount')
            ->orderBy('booked_room_min_booked_for', 'asc')
            ->latest()
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'user.booking.all', compact('pageTitle', 'bookings'));
    }

    public function bookingRequestList()
    {
        $pageTitle = "All Booking Request";
        $bookingRequests = BookingRequest::where('user_id', auth()->id())->with('roomType')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.booking.request', compact('bookingRequests', 'pageTitle'));
    }

    public function deleteBookingRequest($id)
    {
        BookingRequest::initial()->where('user_id', auth()->id())->where('id', $id)->delete();

        $notify[] = ['success', 'Booking request deleted successfully'];
        return back()->withNotify($notify);
    }



    public function bookingDetails($id)
    {
        $user = auth()->user();
        $booking = Booking::where('user_id', $user->id)->with([
             'bookedRoom' => function ($query) {
                $query->select('id','booking_id','room_id','fare','status', 'booked_for')
                ->where('status', 1);
            },
            'bookedRoom.room:id,room_type_id,room_number',
            'bookedRoom.room.roomType:id,name',
            'usedExtraService.room',
            'usedExtraService.extraService',
            'payments'
        ])->findOrFail($id);

        $pageTitle = 'Booking Details Of : ' . $booking->booking_number;

        return view($this->activeTemplate . 'user.booking.details', compact('pageTitle', 'booking'));
    }

    public function payment($id)
    {
        $booking = Booking::findOrFail($id);
        session()->put('amount', getAmount($booking->total_amount - $booking->paid_amount));
        session()->put('booking_id', $booking->id);
        return redirect()->route('user.deposit');
    }
}
