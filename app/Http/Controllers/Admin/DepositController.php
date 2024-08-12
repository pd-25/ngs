<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingActionHistory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Payments';
        $deposits = $this->depositData('pending');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }


    public function approved()
    {
        $pageTitle = 'Approved Payments';
        $deposits = $this->depositData('approved');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Payments';
        $deposits = $this->depositData('successful');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Payments';
        $deposits = $this->depositData('rejected');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function failed()
    {
        $pageTitle = 'Failed Payments';
        $deposits = $this->depositData('failed');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function deposit()
    {
        
        $pageTitle = 'Payment History';
        $depositData = $this->depositData($scope = null, $summery = true);
        $deposits = $depositData['data'];
        $summery = $depositData['summery'];
        $successful = $summery['successful'];
        $pending = $summery['pending'];
        $rejected = $summery['rejected'];
        $failed = $summery['failed'];
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'successful', 'pending', 'rejected', 'failed'));
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
        $general = gs();
        $deposit = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $pageTitle = $deposit->user->username . ' requested ' . showAmount($deposit->amount) . ' ' . $general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit', 'details'));
    }


    public function approve($id)
    {
        $deposit = Deposit::where('id', $id)->where('status', 2)->firstOrFail();

        //action log
        $bookingActionHistory = new BookingActionHistory();
        $bookingActionHistory->remark = 'payment_approved';
        $bookingActionHistory->booking_id = $deposit->booking_id;
        $bookingActionHistory->admin_id = auth()->guard('admin')->id();
        $bookingActionHistory->save();

        PaymentController::userDataUpdate($deposit, true);

        $notify[] = ['success', 'Payment request approved successfully'];

        return to_route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'message' => 'required'
        ]);
        $deposit = Deposit::where('id', $request->id)->where('status', 2)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $user = User::find($deposit->user_id);
        $booking = Booking::find($deposit->booking_id);

        //action log
        $bookingActionHistory = new BookingActionHistory();
        $bookingActionHistory->remark = 'payment_reject';
        $bookingActionHistory->booking_id = $booking->id;
        $bookingActionHistory->admin_id = auth()->guard('admin')->id();
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
        return  to_route('admin.deposit.pending')->withNotify($notify);
    }
}
