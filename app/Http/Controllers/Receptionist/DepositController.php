<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingActionHistory;
use App\Http\Controllers\Gateway\PaymentController;
use Carbon\Carbon;

class DepositController extends Controller
{
    public function pending()
    {
       
        $pageTitle = 'Pending Payments';
       // $deposits = $this->depositData('pending');
        $bookings = $this->bookingData();
        return view('receptionist.deposit.log', compact('pageTitle', 'bookings'));
    }
    
    
     protected function bookingData()
    {
        $request = request();
        $query = Booking::query();

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('mobile', 'like', "%$search%");
            })->orWhere(function ($query) use ($search) {
                $query->where('guest_details->name', 'like', "%$search%")
                    ->orWhere('guest_details->email', 'like', "%$search%")
                    ->orWhere('guest_details->mobile', 'like', "%$search%")
                    ->orWhere('booking_number', 'like', "%" . $search . "%");
            });
        }

        if ($request->date) {
            $date = explode('-', $request->date);

            $request->merge([
                'checkin_date' => trim(@$date[0]),
                'checkout_date' => trim(@$date[1]) ? trim(@$date[1]) : trim(@$date[0])
            ]);

            $request->validate([
                'checkin_date' => 'required|date_format:m/d/Y',
                'checkout_date' => 'nullable|date_format:m/d/Y|after_or_equal:checkin_date'
            ]);

            $checkIn = Carbon::parse($request->checkin_date)->format('Y-m-d');
            $checkOut = Carbon::parse($request->checkout_date)->format('Y-m-d');

            $query->whereHas('bookedRoom', function ($q) use ($checkIn, $checkOut) {
                $q->where('booked_for', '>=', $checkIn)->where('booked_for', '<=', $checkOut);
            });
        }

        return $query->with('bookedRoom.room', 'user')
            ->withMin('bookedRoom', 'booked_for')
            ->withMax('bookedRoom', 'booked_for')
            ->withSum('usedExtraService', 'total_amount')
            ->orderBy('booked_room_min_booked_for', 'asc')
            ->latest()
            ->get();
            //->paginate(getPaginate());
    }


    protected function depositData($scope = null, $summery = false)
    {
        if ($scope) {
            $deposits = Deposit::$scope()->with(['user', 'gateway']);
        } else {
            $deposits = Deposit::with(['user', 'gateway']);
        }

        $request = request();
        //search
        if ($request->search) {
            $search = request()->search;
            $deposits = $deposits->where(function ($q) use ($search) {
                $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
            });
        }

        //date search
        if ($request->date) {
            $date = explode('-', $request->date);
            $request->merge([
                'start_date' => trim(@$date[0]),
                'end_date'  => trim(@$date[1])
            ]);
            $request->validate([
                'start_date'    => 'required|date_format:m/d/Y',
                'end_date'      => 'nullable|date_format:m/d/Y'
            ]);
            if ($request->end_date) {
                $deposits   = $deposits->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
            } else {
                $deposits   = $deposits->whereDate('created_at', Carbon::parse($request->start_date));
            }
        }

        //vai method
        if ($request->method) {
            $method = Gateway::where('alias', $request->method)->firstOrFail();
            $deposits = $deposits->where('method_code', $method->code);
        }

        if (!$summery) {
            return $deposits->orderBy('id', 'desc')->paginate(getPaginate());
        } else {
            $successful = clone $deposits;
            $pending = clone $deposits;
            $rejected = clone $deposits;
            $failed = clone $deposits;

            $successfulSummery = $successful->where('status', 1)->sum('amount');
            $pendingSummery = $pending->where('status', 2)->sum('amount');
            $rejectedSummery = $rejected->where('status', 3)->sum('amount');
            $failedSummery = $failed->where('status', 0)->sum('amount');

            return [
                'data' => $deposits->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending' => $pendingSummery,
                    'rejected' => $rejectedSummery,
                    'failed' => $failedSummery,
                ]
            ];
        }
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $pageTitle = $deposit->user->username . ' requested ' . showAmount($deposit->amount) . ' ' . $general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('receptionist.deposit.detail', compact('pageTitle', 'deposit', 'details'));
    }


    public function approve($id)
    {
        $deposit = Deposit::where('id', $id)->where('status', 2)->firstOrFail();

        //action log
        $bookingActionHistory = new BookingActionHistory();
        $bookingActionHistory->booking_id = $deposit->booking_id;
        $bookingActionHistory->remark = 'payment_approved';
        $bookingActionHistory->receptionist_id = auth()->guard('receptionist')->id();
        $bookingActionHistory->save();

        PaymentController::userDataUpdate($deposit, true);

        $notify[] = ['success', 'Payment request approved successfully'];
        return to_route('receptionist.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'message' => 'required'
        ]);
        $deposit = Deposit::where('id', $request->id)->where('status', 2)->firstOrFail();

        $deposit->receptionist_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $user = User::find($deposit->user_id);
        $booking = Booking::find($deposit->booking_id);

        //action log
        $bookingActionHistory = new BookingActionHistory();
        $bookingActionHistory->remark = 'payment_reject';
        $bookingActionHistory->booking_id = $booking->id;
        $bookingActionHistory->receptionist_id = auth()->guard('receptionist')->id();
        $bookingActionHistory->save();

        notify($user, 'PAYMENT_MANUAL_REJECT', [
            'booking_number' => $booking->booking_number,
            'amount' => showAmount($deposit->amount),
            'charge' => showAmount($deposit->charge),
            'rate' => $deposit->rate,
            'method_name' => $deposit->gateway->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amo)
        ]);

        $notify[] = ['success', 'Payment request rejected successfully'];
        return  to_route('receptionist.deposit.pending')->withNotify($notify);
    }
}
