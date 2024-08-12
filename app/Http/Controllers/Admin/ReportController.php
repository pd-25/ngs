<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingActionHistory;
use App\Models\NotificationLog;
use App\Models\UserLogin;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History - ' . $search;
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.logins', compact('pageTitle', 'search', 'login_logs'));
        }
        $pageTitle = 'User Login History';
        $login_logs = UserLogin::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $login_logs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'login_logs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id', 'desc');
        $search = $request->search;
        if ($search) {
            $logs = $logs->whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        }
        $logs = $logs->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }

    public function bookingActionHistory()
    {
        $pageTitle = 'Booking Actions Report';
        $query = BookingActionHistory::query();
        if (request()->remark) {
            $remark = request()->remark;
            $query = $query->where('remark', $remark);
        }

        if (request()->search) {
            $search = request()->search;
            $query = $query->whereHas('booking', function ($q) use ($search) {
                $q->where('booking_number', $search);
            });
        }
        $remarks = BookingActionHistory::groupBy('remark')->orderBy('remark')->get('remark');
        $bookingLog = $query->with('booking', 'admin', 'receptionist')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.booking_actions', compact('pageTitle', 'bookingLog', 'remarks'));
    }

    public function paymentsReceived()
    {
        return $this->getPaymentData('RECEIVED', 'Received Payments History');
    }

    public function paymentReturned()
    {
        return $this->getPaymentData('RETURNED', 'Returned Payments History');
    }

    protected function getPaymentData($type, $pageTitle)
    {
        $query = PaymentLog::where('type', $type);

        if (request()->search) {
            $search = request()->search;
            $query = $query->whereHas('booking', function ($q) use ($search) {
                $q->where('booking_number', $search)
                    ->orWhere('guest_details->name', 'like', "%$search%")
                    ->orWhere('guest_details->email', "$search")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', $search);
                    });
            });
        }

        $paymentLog = $query->with('booking.user', 'receptionist', 'admin')->orderBy('id', 'desc')->paginate(getPaginate());

        return view('admin.reports.payment_history', compact('pageTitle', 'paymentLog', 'pageTitle'));
    }
}
