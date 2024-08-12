<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\BookedRoom;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Models\BookingActionHistory;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\PaymentLog;
use App\Models\UsedExtraService;
use App\Models\ExtraService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

trait ManageBooking
{
    protected $userType;

    public function room()
    {
        $pageTitle = 'Book Room';

        $roomTypes = RoomType::active()->get(['id', 'name']);
        return view($this->userType . '.booking.book', compact('pageTitle', 'roomTypes'));
    }

    public function todaysBooked()
    {
        $pageTitle = 'Todays Booked Rooms';
        if (request()->type == 'not_booked') {
            $pageTitle = 'Available Rooms to Book Today';
        }


        $rooms = BookedRoom::active()
            ->with([
                'room:id,room_number,room_type_id',
                'room.roomType:id,name',
                'booking:id,user_id,booking_number',
                'booking.user:id,firstname,lastname',
                'extraServices.extraService:id,name'
            ])
            ->where('booked_for', now()->toDateString())
            ->get();

        $bookedRooms = $rooms->pluck('room_id')->toArray();



        $emptyRooms = Room::whereNotIn('id', $bookedRooms)->with('roomType:id,name')->select('id', 'room_type_id', 'room_number')->get();

        $ExtraService = ExtraService::where('status', 1)->get();

        $selectedDate = now()->toDateString();

        $totalRooms_1 = RoomType::where('id', 1)->first();
        $totalRooms_2 = RoomType::where('id', 2)->first();
        $totalRooms_3 = RoomType::where('id', 3)->first();

        $occupiedRooms_1 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 1)->count();
        $occupiedRooms_2 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 2)->count();
        $occupiedRooms_3 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 3)->count();

        return view($this->userType . '.booking.todays_booked', compact('pageTitle', 'rooms', 'emptyRooms', 'totalRooms_1', 'totalRooms_2', 'totalRooms_3', 'occupiedRooms_1', 'occupiedRooms_2', 'occupiedRooms_3', 'ExtraService', 'selectedDate'));
    }

    public function searchRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type'  => 'required|exists:room_types,id',
            'date'       => 'required',
            'rooms'      => 'required|integer|gt:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $datepickerFormat = 'd-M-Y h:i A';
        $dateString = explode('To', $request->date);
        $checkinDateTime = Carbon::createFromFormat($datepickerFormat, trim($dateString[0]));
        $checkoutDateTime = Carbon::createFromFormat($datepickerFormat, trim($dateString[1]));
        // Adjust check-in date if before 12 PM (noon)
        if ($checkinDateTime->hour < 12) {
            $checkinDateTime->subDay(); // Move check-in date to previous day
        }
        if ($checkoutDateTime->hour >= 12) {
            $checkoutDateTime->addDay(); // Move checkout date to next day
        } else {
            $checkoutDateTime->subDay();
        }


        $request->merge([
            'checkin_date'  => $checkinDateTime->format('Y-m-d'),
            'checkout_date' => $checkoutDateTime->format('Y-m-d'),
        ]);

        $view = $this->getRooms($request);
        $services = $this->getServices();

        return response()->json(['html' => $view, 'services' => $services]);
    }










    // This method also inherited in ManageBookingRequest Trait.
    private function getServices()
    {

        $extraServices = ExtraService::active()->get();
        return view('partials.get_services', compact('extraServices'))->render();
    }

    private function getRooms(Request $request)
    {
        $checkIn  = Carbon::parse($request->checkin_date);
        $checkOut = Carbon::parse($request->checkout_date);
        $rooms    = Room::active()
            ->where('room_type_id', $request->room_type)
            ->with([
                'booked' => function ($q) use ($checkIn) {
                    $q->where('booked_for', '>=', $checkIn->format('Y-m-d'))->active();
                },
                'roomType' => function ($q) {
                    $q->select('id', 'name', 'fare');
                }
            ])
            ->get();

        if (count($rooms) < $request->rooms) {
            return ['error' => ['The requested number of rooms is not available for the selected date']];
        }

        $numberOfRooms = $request->rooms;
        $requestUnitFare = $request->unit_fare;

        return view('partials.rooms', compact('checkIn', 'checkOut', 'rooms', 'numberOfRooms', 'requestUnitFare'))->render();
    }

    // public function book(Request $request)
    // {



    //     $validator = Validator::make($request->all(), [
    //         'guest_type'       => 'required|in:1,0',
    //         'guest_name'       => 'nullable|required_if:guest_type,0',
    //         'email'            => 'required|email',
    //         'mobile'           => 'nullable|required_if:guest_type,0|regex:/^([0-9]*)$/',
    //         'room'             => 'required|array',
    //         'paid_amount'      => 'nullable|integer|gte:0'
    //     ]);


    //     if (!$validator->passes()) {
    //         return response()->json(['error' => $validator->errors()->all()]);
    //     }



    //     if ($request->paid_amount > $request->total_amount) {
    //         return response()->json(['error' => ['Paying amount can\'t be greater than total amount']]);
    //     }
    //     $guest = [];

    //     if ($request->guest_type == 1) {
    //         $user = User::where('email', $request->email)->first();
    //         if (!$user) {
    //             return response()->json(['error' => ['User not found']]);
    //         }
    //     } else {
    //         $guest['name']   = $request->guest_name;
    //         $guest['email']  = $request->email;
    //         $guest['mobile'] = $request->mobile;
    //         $guest['dob'] = $request->dob;
    //         $guest['address'] = $request->address;
    //         $guest['state'] = $request->state;
    //         $guest['city'] = $request->city;
    //         $guest['pincode'] = $request->pincode;
    //         $guest['c_d_c_number'] = $request->c_d_c_number;
    //         $guest['cheak_in_time'] = $request->cheak_in_time;
    //         $guest['payment_mode'] = $request->payment_mode;

    //         ////////

    //         $newObject = new \stdClass();

    //         $newObject->country = "";
    //         $newObject->address = $request->address;
    //         $newObject->state = $request->state;
    //         $newObject->zip = $request->pincode;
    //         $newObject->city = $request->city;

    //         $userData   = new User();
    //         $userData->firstname = $request->guest_name;
    //         $userData->lastname       = "";
    //         $userData->country_code       = "IN";

    //         $userData->username = $request->email;
    //         $userData->email  = $request->email;
    //         $userData->address   = $newObject;
    //         $userData->dob        = $request->dob;
    //         $userData->cdc        = $request->c_d_c_number;
    //         $userData->rank        = $request->rank;
    //         $userData->save();
    //         ////////

    //     }

    //     $bookedRoomData = [];


    //     $roomnumber = [];
    //     //     $dateTime = Carbon::parse($checkInTime);
    //     // $hour = $dateTime->hour;
    //     foreach ($request->room as $room) {
    //         $data = [];
    //         $allromm = [];
    //         $roomId     = explode('-', $room)[0];
    //         if ($roomId) {


    //             $roomno = Room::where('id', $roomId)->first();

    //             if (!in_array($roomno->room_number, $roomnumber)) {

    //                 $roomnumber[] = $roomno->room_number;
    //             }
    //         }

    //         $bookedFor  = explode('-', $room)[1];

    //         // Check if already booked for this date;
    //         $isBooked = BookedRoom::where('room_id', $roomId)->where('booked_for', $bookedFor)->exists();

    //         if ($isBooked) {
    //             return response()->json(['error' => ['Something went wrong!']]);
    //         }


    //         $room               = Room::with('roomType')->findOrFail($roomId);
    //         $data['booking_id'] = 0;
    //         $data['room_id']    = $room->id;
    //         $data['booked_for'] = Carbon::parse($bookedFor)->format('Y-m-d');
    //         $data['fare']       = $room->roomType->fare;
    //         $data['status']     = 1;
    //         $bookedRoomData[]   = $data;
    //     }

    //     $fileName = $request->file;



    //     $roomNumber = implode(', ', $roomnumber);
    //     $booking                = new Booking();
    //     $booking->booking_number = $this->generateBookingNumber();
    //     $booking->user_id       = $request->booked_user_id ? $request->booked_user_id : 0;
    //     $booking->guest_details = $guest;
    //     $booking->total_amount  = $request->total_amount;
    //     $booking->paid_amount   = $request->paid_amount ?? 0;
    //     $booking->status        = 1;
    //     $booking->room_number        = $roomNumber;
    //     $booking->image        = $fileName;
    //     $booking->save();

    //     if ($request->paid_amount) {
    //         $this->paymentLog($booking->id, $request->paid_amount, 'RECEIVED');
    //     }

    //     $this->bookingActionHistory('book_room', $booking->id);

    //     $bookedRoomData = collect($bookedRoomData)->map(function ($data) use ($booking) {
    //         $data['booking_id'] = $booking->id;
    //         return $data;
    //     });

    //     BookedRoom::insert($bookedRoomData->toArray());

    //     // extra services functionality
    //     foreach ($request->room as $room) {

    //         $roomId  = explode('-', $room)[0];
    //         $room_no = Room::where('id', $roomId)->first();

    //         if ($room_no) {
    //             $roomNumber = $room_no->room_number;
    //         }

    //         $bookedFor  = explode('-', $room)[1];

    //         $service_date =  Carbon::parse($bookedFor)->format('Y-m-d');



    //         $serviceRoom = BookedRoom::whereHas('room', function ($q) use ($roomNumber, $service_date) {
    //             $q->where('room_number', $roomNumber);
    //         })->whereDate('booked_for', $service_date)->where('status', 1)->first();


    //         $bookings = Booking::find($serviceRoom->booking_id);

    //         $totalAmount = 0;
    //         $datas = [];

    //         foreach ($request->services as $key => $service) {
    //             $serviceDetails                     = ExtraService::find($service);
    //             $datas[$key]['booking_id']           = $bookings->id;
    //             $datas[$key]['extra_service_id']     = $service;
    //             $datas[$key]['room_id']              = $serviceRoom->room_id;
    //             $datas[$key]['booked_room_id']       = $serviceRoom->id;
    //             $datas[$key]['qty']                  = $request->qty[$key];
    //             $datas[$key]['unit_price']           = $serviceDetails->cost;
    //             $datas[$key]['total_amount']         = $request->qty[$key] * $serviceDetails->cost;
    //             $datas[$key]['service_date']         = $service_date;
    //             $datas[$key]['receptionist_id']      = $request->booked_user_id;
    //             $totalAmount += $request->qty[$key] * $serviceDetails->cost;
    //             $datas[$key]['created_at']           = now();
    //             $datas[$key]['updated_at']           = now();

    //         }

    //         $usedExtraService  = new UsedExtraService();
    //         $usedExtraService->insert($datas);

    //         $bookings->total_amount += $totalAmount;
    //         $bookings->save();

    //         $action = new BookingActionHistory();
    //         $action->booking_id = $bookings->id;
    //         $action->remark = 'added_extra_service';
    //         $action->receptionist_id = $request->booked_user_id;
    //         $action->save();
    //     }


    //     return response()->json(['success' => ['Room booked successfully']]);
    // }
    /**
     * pradipta 6th-july 2024
     * 
     */
    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guest_type'       => 'required|in:1,0',
            'guest_name'       => 'nullable|required_if:guest_type,0',
            'email'            => 'required|email',
            'mobile'           => 'nullable|required_if:guest_type,0|regex:/^([0-9]*)$/',
            'room'             => 'required|array',
            'paid_amount'      => 'nullable|integer|gte:0'
        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if ($request->paid_amount > $request->total_amount) {
            return response()->json(['error' => ['Paying amount can\'t be greater than total amount']]);
        }

        try {
            DB::beginTransaction();
            $guest = $this->handleGuest($request);
            if ($guest instanceof \Illuminate\Http\JsonResponse) {
                return $guest;
            }

            $bookedRoomData = $this->prepareBookedRoomData($request);
            if ($bookedRoomData instanceof \Illuminate\Http\JsonResponse) {
                return $bookedRoomData;
            }

            $fileName = $request->file;
            $roomNumber = implode(', ', array_column($bookedRoomData, 'room_number'));

            $booking = $this->createBooking($request, $guest, $roomNumber, $fileName);

            if ($request->paid_amount) {
                $this->paymentLog($booking->id, $request->paid_amount, 'RECEIVED');
            }

            $this->bookingActionHistory('book_room', $booking->id);

            $bookedRoomData = collect($bookedRoomData)->map(function ($data) use ($booking) {
                $data['booking_id'] = $booking->id;
                unset($data['room_number']);
                return $data;
            });

            $chunkedRoomData = $bookedRoomData->chunk(50); // process in chunks of 50

            foreach ($chunkedRoomData as $chunk) {
                BookedRoom::insert($chunk->toArray());
            }

            $this->handleExtraServices($request, $bookedRoomData);
            DB::commit();
            return response()->json(['success' => ['Room booked successfully']]);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::debug('Error-', [$th->getMessage()]);
            Log::debug('ErrorLine-', [$th->getLine()]);
        }
    }

    private function handleGuest($request)
    {
        if ($request->guest_type == 1) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => ['User not found']]);
            }
            return [
                'name' => $user->guest_name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'dob' => $user->dob,
                'address' => $user->address,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'c_d_c_number' => $user->c_d_c_number,
                'cheak_in_time' => $request->cheak_in_time,
                'payment_mode' => $request->payment_mode,
            ];
        } else {
            $guest = [
                'name' => $request->guest_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'dob' => $request->dob,
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'c_d_c_number' => $request->c_d_c_number,
                'cheak_in_time' => $request->cheak_in_time,
                'payment_mode' => $request->payment_mode,
            ];

            $userData = new User();
            $userData->firstname = $request->guest_name;
            $userData->lastname = "";
            $userData->country_code = "IN";
            $userData->username = $request->email;
            $userData->email = $request->email;
            $userData->address = $request->address;
            $userData->dob = $request->dob;
            $userData->cdc = $request->c_d_c_number;
            $userData->rank = $request->rank;
            $userData->save();

            return $guest;
        }
    }

    private function prepareBookedRoomData($request)
    {
        $bookedRoomData = [];
        $roomIds = [];
        $roomnumber = [];

        foreach ($request->room as $room) {
            $roomId = explode('-', $room)[0];
            $bookedFor = explode('-', $room)[1];

            if (!in_array($roomId, $roomIds)) {
                $roomIds[] = $roomId;
            }

            $room = Room::with('roomType')->find($roomId);
            if (!$room) {
                continue;
            }

            $roomno = $room->room_number;
            if (!in_array($roomno, $roomnumber)) {
                $roomnumber[] = $roomno;
            }

            $isBooked = BookedRoom::where('room_id', $roomId)->where('booked_for', $bookedFor)->exists();
            if ($isBooked) {
                return response()->json(['error' => ['Something went wrong!']]);
            }

            $bookedRoomData[] = [
                'booking_id' => 0,
                'room_id' => $room->id,
                'booked_for' => Carbon::parse($bookedFor)->format('Y-m-d'),
                'fare' => $room->roomType->fare,
                'status' => 1,
                'room_number' => $roomno,
            ];
        }

        return $bookedRoomData;
    }

    private function createBooking($request, $guest, $roomNumber, $fileName)
    {
        $booking = new Booking();
        $booking->booking_number = $this->generateBookingNumber();
        $booking->user_id = $request->booked_user_id ? $request->booked_user_id : 0;
        $booking->guest_details = $guest;
        $booking->total_amount = $request->total_amount;
        $booking->paid_amount = $request->paid_amount ?? 0;
        $booking->status = 1;
        $booking->room_number = $roomNumber;
        $booking->image = $fileName;
        $booking->save();

        return $booking;
    }

    private function handleExtraServices($request, $bookedRoomData)
    {
        $serviceData = [];
        foreach ($request->room as $room) {
            $roomId = explode('-', $room)[0];
            $bookedFor = explode('-', $room)[1];
            $service_date = Carbon::parse($bookedFor)->format('Y-m-d');

            $room_no = Room::where('id', $roomId)->first()->room_number ?? null;
            if (!$room_no) continue;

            $serviceRoom = BookedRoom::whereHas('room', function ($q) use ($room_no, $service_date) {
                $q->where('room_number', $room_no);
            })->whereDate('booked_for', $service_date)->where('status', 1)->first();

            if (!$serviceRoom) continue;

            $bookingId = $serviceRoom->booking_id;
            $totalAmount = 0;

            foreach ($request->services as $key => $service) {
                $serviceDetails = ExtraService::find($service);
                $unitPrice = $serviceDetails->cost;
                $quantity = $request->qty[$key];
                $totalAmount += $unitPrice * $quantity;
                $serviceData[] = [
                    'booking_id' => $bookingId,
                    'extra_service_id' => $service,
                    'room_id' => $serviceRoom->room_id,
                    'booked_room_id' => $serviceRoom->id,
                    'service_date' => $service_date,
                    'receptionist_id' => $request->booked_user_id,
                    'unit_price' => $unitPrice,
                    'qty' => $quantity,
                    'total_amount' => $unitPrice * $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->bookingActionHistory('extra_service', $bookingId, $totalAmount);
            Booking::where('id', $bookingId)->increment('total_amount', $totalAmount);
        }

        if (!empty($serviceData)) {
            $chunkedServiceData = collect($serviceData)->chunk(50); // process in chunks of 50
            foreach ($chunkedServiceData as $chunk) {
                UsedExtraService::insert($chunk->toArray());
            }
        }
    }

    /**
     * end
     */

    public function activeBookings()
    {
        $pageTitle = 'Upcoming and Running';
        $bookings = $this->bookingData('active');
        return view($this->userType . '.booking.list', compact('pageTitle', 'bookings'));
    }

    public function checkedOutBookingList()
    {
        $pageTitle = 'Checked Out Bookings';
        $bookings = $this->bookingData('checkedOut');
        return view($this->userType . '.booking.list', compact('pageTitle', 'bookings'));
    }

    public function cancelledBookingList()
    {
        $pageTitle = 'Cancelled Bookings';
        $bookings = $this->bookingData('cancelled');

        return view($this->userType . '.booking.list', compact('pageTitle', 'bookings'));
    }

    public function allBookingList()
    {

        $pageTitle = 'All Bookings';
        $bookings  = $this->bookingData('ALL');

        return view($this->userType . '.booking.list', compact('pageTitle', 'bookings'));
    }

    public function inactiveActiveStatus(Request $request)
    {

        $pageTitle = 'All Bookings';
        $bookings  = $this->bookingData('ALL');

        return view($this->userType . '.booking.list', compact('pageTitle', 'bookings'));
    }

    public function mergeBooking(Request $request, $id)
    {
        $parentBooking = Booking::active()->findOrFail($id);

        $request->merge(['merge_with' => $parentBooking->booking_number]);

        $request->validate([
            'booking_numbers'   => 'required|array',
            'booking_numbers.*' => 'exists:bookings,booking_number|different:merge_with'
        ], [
            'booking_numbers.*.different' => 'All booking numbers must be different from the booking number of merging with'
        ]);

        // Check if available to merge
        $check =  Booking::whereIn('booking_number', $request->booking_numbers)->where('status', '!=', 1)->first();

        if ($check) {
            $notify[] = ['error', $check->booking_number . ' can\'t be merged. Only running bookings are able to merge.'];
            return back()->withNotify($notify);
        }

        foreach ($request->booking_numbers as $orderNumber) {
            $booking = Booking::where('booking_number', $orderNumber)->first();
            $booking->usedExtraService()->update(['booking_id' => $parentBooking->id]);
            $booking->bookedRoom()->update(['booking_id' => $parentBooking->id]);

            BookingActionHistory::where('booking_id', $booking->id)->delete();
            PaymentLog::where('booking_id', $booking->id)->update(['booking_id' => $parentBooking->id]);

            $parentBooking->total_amount += $booking->total_amount;
            $parentBooking->paid_amount += $booking->paid_amount;
            $parentBooking->save();
            $booking->delete();
        }

        $action = new BookingActionHistory();
        $action->booking_id = $parentBooking->id;
        $action->remark = 'merged_booking';
        $action->details = implode(', ', $request->booking_numbers) . ' merged with ' . $parentBooking->booking_number;

        $column = $this->column;
        $action->$column = $this->user->id;

        $action->save();

        $notify[] = ['success', 'Bookings merged successfully'];
        return redirect()->route($this->userType . '.booking.details', $parentBooking->id)->withNotify($notify);
    }


    public function payment(Request $request, $id)
    {
        $request->validate([
            'type'   => 'string|in:return,receive',
            'amount' => 'required|integer|gt:0'
        ]);

        $booking = Booking::withSum('usedExtraService', 'total_amount')
            ->withSum(['bookedRoom' => function ($booked) {
                $booked->where('status', 1);
            }], 'fare')->findOrFail($id);

        $booking = $this->adjustTotalAmount($booking);

        if ($booking->status != 1) {
            $notify[] = ['error', 'Amount should be paid while booking is active'];
            return back()->withNotify($notify);
        }

        if ($request->type == 'receive') {
            return $this->receivePayment($booking, $request->amount);
        }
        return $this->returnPayment($booking, $request->amount);
    }


    protected function receivePayment($booking, $receivingAmount)
    {

        $due = $booking->total_amount - $booking->paid_amount;

        if ($receivingAmount > $due) {
            $notify[] = ['error', 'Amount shouldn\'t be greater than payable amount'];
            return back()->withNotify($notify);
        }

        $this->deposit($booking, $receivingAmount);
        $this->paymentLog($booking->id, $receivingAmount, 'RECEIVED');
        $this->bookingActionHistory('payment_received', $booking->id);

        $booking->paid_amount += $receivingAmount;
        $booking->save();

        $notify[] = ['success', 'Payment received successfully'];
        return back()->withNotify($notify);
    }

    protected function returnPayment($booking, $receivingAmount)
    {

        $due = $booking->total_amount - $booking->paid_amount;


        if ($due > 0) {
            $notify[] = ['error', 'Invalid action'];
            return back()->withNotify($notify);
        }

        $due = abs($due);

        if ($receivingAmount > $due) {
            $notify[] = ['error', 'Amount shouldn\'t be greater than payable amount'];
            return back()->withNotify($notify);
        }

        $this->paymentLog($booking->id, $receivingAmount, 'RETURNED');
        $this->bookingActionHistory('payment_returned', $booking->id);

        $booking->paid_amount -= $receivingAmount;
        $booking->save();

        $notify[] = ['success', 'Payment received successfully'];
        return back()->withNotify($notify);
    }

    protected function deposit($booking, $payableAmount)
    {
        $gate = GatewayCurrency::where('id', 0)->first();

        $data = new Deposit();
        $data->user_id = $booking->user_id;
        $data->booking_id = $booking->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $payableAmount;
        $data->charge = 0;
        $data->rate = $gate->rate;
        $data->final_amo = $payableAmount;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 1;
        $data->save();
    }

    public function checkOutPreview($id)
    {
        $booking = Booking::withSum('usedExtraService', 'total_amount')
            ->withSum(['bookedRoom' => function ($booked) {
                $booked->where('status', 1);
            }], 'fare')->findOrFail($id);

        if ($booking->status != 1) {
            $notify[] = ['error', 'This is not an active booking.'];
            return back()->withNotify($notify);
        }

        $booking = $this->adjustTotalAmount($booking);


        $pageTitle = "Check Out - " . $booking->booking_number;
        return view($this->userType . '.booking.check_out', compact('pageTitle', 'booking'));
    }

    public function checkOut($id)
    {
        $booking = Booking::active()->withMin('bookedRoom', 'booked_for')->withSum('usedExtraService', 'total_amount')->findOrFail($id);

        $checkedInDate = $booking->booked_room_min_booked_for;

        if ($checkedInDate > now()->toDateString()) {
            $notify[] = ['error', 'Check-in date for this booking is greater than now'];
            return back()->withNotify($notify);
        }

        $totalAmount = $booking->total_amount - $booking->used_extra_service_sum_total_amount ?? 0;
        $dueAmount = $totalAmount - $booking->paid_amount;

        if ($dueAmount > 0) {
            $notify[] = ['error', 'The due amount must be paid before check-out.'];
            return back()->withNotify($notify);
        }

        if ($dueAmount < 0) {
            $notify[] = ['error', 'Pay the extra amount to the guest, before checkout.'];
            return back()->withNotify($notify);
        }

        $this->bookingActionHistory('checked_out', $booking->id);

        $booking->bookedRoom()->where('status', '!=', 3)->update(['status' => 9]);
        $booking->status = 9;
        $booking->checked_out_at = now();

        $booking->save();

        $notify[] = ['success', 'Booking checked out successfully'];
        return redirect()->route($this->userType . '.booking.checkout', $id)->withNotify($notify);
    }


    public function generateInvoice($bookingId)
    {

        $minDate = BookedRoom::where('booking_id', $bookingId)->min('booked_for');

        // Retrieve the maximum date for the specific record
        $maxDate = BookedRoom::where('booking_id', $bookingId)->max('booked_for');
        $fare = BookedRoom::select('fare')->where('booking_id', $bookingId)->max('fare');

        $booking = Booking::with([
            'bookedRoom' => function ($query) {
                $query->select('id', 'booking_id', 'room_id', 'fare', 'status', 'booked_for')
                    ->where('status', 1);
            },
            'bookedRoom.room:id,room_type_id,room_number',
            'bookedRoom.room.roomType:id,name',
            'usedExtraService.room',
            'usedExtraService.extraService',
            'user:id,firstname,lastname,username,email,mobile',
            'payments'
        ])
            ->withSum(['bookedRoom' => function ($booked) {
                $booked->where('status', 1);
            }], 'fare')
            ->withSum('usedExtraService', 'total_amount')
            ->findOrFail($bookingId);

        $booking = $this->adjustTotalAmount($booking);

        $data = [
            'booking' => $booking,
            'mindate' =>  $minDate,
            'maxdate' =>  $maxDate,
            'fare' =>  $fare,
        ];

        $pdf = PDF::loadView('partials.invoice', $data);

        return $pdf->stream($booking->booking_number . '.pdf');
    }

    protected function adjustTotalAmount($booking)
    {
        if ($booking->booked_room_sum_fare && ($booking->total_amount != $booking->booked_room_sum_fare)) {
            $booking->total_amount = $booking->booked_room_sum_fare;
            $booking->save();
        }

        return $booking;
    }

    function bookingDetails($id)
    {
        $booking = Booking::findOrFail($id);
        $pageTitle  = 'Booking Details of ' . $booking->booking_number;
        $bookedRooms = BookedRoom::where('booking_id', $id)->with('booking.user', 'room.roomType')->orderBy('booked_for')->get()->groupBy('booked_for');
        return view($this->userType . '.booking.details', compact('pageTitle', 'bookedRooms', 'booking'));
    }


    public function extraServiceDetail($id)
    {
        $booking = Booking::where('id', $id)->firstOrFail();
        $services = UsedExtraService::where('booking_id', $id)->with('extraService', 'room')->paginate(getPaginate());
        $pageTitle = 'Service Details - ' . $booking->booking_number;
        return view($this->userType . '.booking.service_details', compact('pageTitle', 'services'));
    }




    protected function bookingData($scope)
    {
        $request = request();
        $query = Booking::query()->orderBy('id', 'DESC');

        if ($scope != "ALL") {
            $query = $query->$scope();
        }

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like',  "%$search%")
                    ->orWhere('mobile', 'like',  "%$search%");
            })->orWhere(function ($query) use ($search) {
                $query->where('guest_details->name', 'like', "%$search%")
                    ->orWhere('guest_details->email', 'like', "%$search%")
                    ->orWhere('guest_details->mobile', 'like', "%$search%")
                    ->orWhere('booking_number', 'like', "%" . $search . "%");
            });
        }

        if ($request->date) {
            $date  = explode('-', $request->date);

            $request->merge([
                'checkin_date'  => trim(@$date[0]),
                'checkout_date' => trim(@$date[1]) ? trim(@$date[1]) : trim(@$date[0])
            ]);

            $request->validate([
                'checkin_date'  => 'required|date_format:m/d/Y',
                'checkout_date' => 'nullable|date_format:m/d/Y|after_or_equal:checkin_date'
            ]);

            $checkIn  = Carbon::parse($request->checkin_date)->format('Y-m-d');
            $checkOut = Carbon::parse($request->checkout_date)->format('Y-m-d');

            $query->whereHas('bookedRoom', function ($q) use ($checkIn, $checkOut) {
                $q->where('booked_for', '>=', $checkIn)->where('booked_for', '<=', $checkOut);
            });
        }
        if ($request->filter) {
            if ($request->filter == 9) {
                $query->where('status', 9);
            }
            if ($request->filter == 1) {
                $query->where('status', 1);
            }
        } else {
            $query->where('status', 1);
        }

        return $query->with('bookedRoom.room', 'user')
            ->withMin('bookedRoom', 'booked_for')
            ->withMax('bookedRoom', 'booked_for')
            ->withSum('usedExtraService', 'total_amount')
            ->orderBy('booked_room_min_booked_for', 'asc')
            ->latest()
            ->paginate(getPaginate());
    }

    protected function bookingActionHistory($remark, $bookingId, $details = null)
    {
        $bookingActionHistory = new BookingActionHistory();

        $bookingActionHistory->booking_id = $bookingId;
        $bookingActionHistory->remark = $remark;
        $bookingActionHistory->details = $details;

        $column = $this->column;
        $bookingActionHistory->$column = $this->user->id;
        $bookingActionHistory->save();
    }

    protected function paymentLog($bookingId, $amount, $type)
    {
        $column = $this->column;

        $paymentLog             = new PaymentLog();
        $paymentLog->booking_id = $bookingId;
        $paymentLog->amount     = $amount;
        $paymentLog->type       = $type;
        $paymentLog->payment_mode = request()->input('payment_mode'); // Save the payment mode
        $paymentLog->remark     = request()->input('remark'); // Save the remark
        $paymentLog->$column    = $this->user->id;
        $paymentLog->save();
    }



    public function cancelBooking($id)
    {
        $booking = Booking::active()->withMin('bookedRoom', 'booked_for')->findOrFail($id);

        $checkIn = $booking->booked_room_min_booked_for;
        // dd($checkIn);

        // if ($checkIn <= now()->toDateString()) {
        //     $notify[] = ['error', 'Only future days bookings can be cancelled'];
        //     return back()->withNotify($notify);
        // }

        $this->bookingActionHistory('cancel_booking', $booking->id);
        $booking->bookedRoom()->update(['status' => 3]);
        $booking->status = 3;
        $booking->save();

        $rooms = Room::whereIn('id', $booking->bookedRoom()->pluck('room_id')->toArray())->get()->pluck('room_number')->toArray();


        // Return the paid amount to user
        if ($booking->paid_amount > 0) {
            $this->paymentLog($booking->id, $booking->paid_amount, 'RETURNED');
            $booking->paid_amount = 0;
        }

        if ($booking->user) {
            notify($booking->user, 'BOOKING_CANCELLED', [
                'booking_number' => $booking->booking_number,
                'rooms' => implode(', ', $rooms),
                'check_in' => Carbon::parse($booking->bookedRoom->first()->booked_for)->format('d M, Y'),
                'check_out' => Carbon::parse($booking->bookedRoom->last()->booked_for)->format('d M, Y')
            ]);
        }

        $notify[] = ['success', 'Booking cancelled successfully'];
        return back()->with($notify);
    }


    public function cancelBookingByDate($id, $date)
    {
        $booking = Booking::findOrFail($id);

        if ($date <= now()->format('Y-m-d')) {
            $notify[] = ['error', 'Only upcoming bookings can be cancelled'];
            return back()->withNotify($notify);
        }

        if ($booking->status == 9 || $booking->status == 3) {
            $notify[] = ['error', 'This booking can\'t be cancelled'];
            return back()->withNotify($notify);
        }

        $roomsFare = $booking->bookedRoom()->where('booked_for', $date)->sum('fare');
        $booking->total_amount -= $roomsFare;
        $booking->save();

        $booking->bookedRoom()->where('booked_for', $date)->update(['status' => 3]);
        $this->bookingActionHistory('cancel_booking', $booking->id, 'Canceled Booking of ' . showDateTime($date, 'd M, Y'));

        $bookedRooms = $booking->bookedRoom()->where('booked_for', $date)->pluck('room_id')->toArray();
        $rooms = Room::whereIn('id', $bookedRooms)->get()->pluck('room_number')->toArray();

        if ($booking->user) {
            notify($booking->user, 'BOOKING_CANCELLED_BY_DATE', [
                'booking_number' => $booking->booking_number,
                'date' => showDateTime($date, 'd M, Y'),
                'rooms' => implode(', ', $rooms)
            ]);
        }

        $notify[] = ['success', 'Booking cancelled successfully'];
        return back()->with($notify);
    }


    public function cancelBookedRoom($id)
    {
        $bookedRoom = BookedRoom::findOrFail($id);

        if (now()->toDateString() <= $bookedRoom->booked_for) {
            $notify[] = ['error', 'Only future date\'s bookings can be cancelled'];
            return back()->withNotify($notify);
        }

        if ($bookedRoom->status == 9 || $bookedRoom->status == 3) {
            $notify[] = ['error', 'This room can\'t be cancelled'];
            return back()->withNotify($notify);
        }

        $booking    = Booking::find($bookedRoom->booking_id);

        $this->bookingActionHistory('cancel_room', $booking->id);

        $booking->total_amount -= $bookedRoom->fare;
        $booking->save();
        $bookedRoom->status = 3;

        $bookedRoom->save();
        $notify[] = ['success', 'Room cancelled successfully'];
        return back()->with($notify);
    }

    protected function generateBookingNumber()
    {
        $prefix = 'NGS';
        $date = now()->format('Ymd');
        $lastBooking = Booking::latest()->first();

        if ($lastBooking) {
            $lastNumber = $lastBooking->booking_number;
            $lastSerial = (int)substr($lastNumber, -6);
            $serial = str_pad($lastSerial + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $serial = '000001';
        }

        return $prefix . $date . $serial;
    }

    public function showInvoice($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        return view('partials.invoice', compact('booking'));
    }
}
