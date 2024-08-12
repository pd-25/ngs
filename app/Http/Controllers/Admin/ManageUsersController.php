<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Booking;
use App\Models\BookingRequest;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManageUsersController extends Controller
{

    public function allUsers()
    {
        $this->pageTitle = 'All Users';
        return $this->userData();
    }

    public function activeUsers()
    {
        $this->pageTitle = 'Active Users';
        return $this->userData('active');
    }

    public function bannedUsers()
    {
        $this->pageTitle = 'Banned Users';
        return $this->userData('banned');
    }

    public function emailUnverifiedUsers()
    {
        $this->pageTitle = 'Email Unverified Users';
        return $this->userData('emailUnverified');
    }

    public function emailVerifiedUsers()
    {
        $this->pageTitle = 'Email Verified Users';
        return $this->userData('emailVerified');
    }

    public function mobileUnverifiedUsers()
    {
        $this->pageTitle = 'Mobile Unverified Users';
        return $this->userData('mobileUnverified');
    }

    public function mobileVerifiedUsers()
    {
        $this->pageTitle = 'Mobile Verified Users';
        return $this->userData('mobileVerified');
    }

    protected function userData($scope = null)
    {
        if ($scope) {
            $users = User::$scope();
        } else {
            $users = User::query();
        }

        $request   = request();

        if ($request->search) {
            $search = $request->search;
            $users  = $users->where(function ($user) use ($search) {
                $user->where('username', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        }

        $pageTitle = $this->pageTitle;
        $users     = $users->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function detail($id)
    {
        $user                        = User::findOrFail($id);
        $pageTitle                   = 'User Detail - ' . $user->username;

        $widget['total_bookings']    = Booking::where('user_id', $id)->count();
        $widget['running_bookings']  = Booking::active()->where('user_id', $id)->count();
        $widget['booking_requests']  = BookingRequest::initial()->where('user_id', $id)->count();
        $widget['total_payment']     = Deposit::successful()->where('user_id', $id)->sum('amount');

        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('admin.users.detail', compact('pageTitle', 'user', 'countries', 'widget'));
    }
    
    public function cdc(Request $request)
    {
        $UserData = User::where('cdc', $request->cdc)->first();
        echo json_encode($UserData);
    }


    public function update(Request $request, $id)
    {
        $user           = User::findOrFail($id);
        $countryData    = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray   = (array) $countryData;
        $countries      = implode(',', array_keys($countryArray));
        $countryCode    = $request->country;
        $country        = $countryData->$countryCode->country;
        $dialCode       = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'mobile'    => ['regex:/^([0-9]*)$/', 'unique:users,mobile,' . $user->id],
            'country'   => 'required|in:' . $countries,
        ]);


        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $countryCode        = $request->country;
        $user->mobile       = $dialCode . $request->mobile;
        $user->country_code = $countryCode;
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->email        = $request->email;
        $user->address      = [
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'zip'           => $request->zip,
            'country'       =>  @$country,
        ];
        $user->ev           = $request->ev ? 1 : 0;
        $user->sv           = $request->sv ? 1 : 0;
        
        $user->dob        = $request->dob;
        $user->cdc        = $request->cdc;
        $user->rank        = $request->rank;
        
        $user->save();

        $notify[] = ['success', 'User detail updated successfully'];
        return back()->withNotify($notify);
    }

    public function login($id)
    {
        Auth::loginUsingId($id);
        return to_route('user.home');
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 1) {
            $request->validate([
                'reason' => 'required'
            ]);
            $user->status = 0;
            $user->ban_reason = $request->reason;
            $notify[] = ['success', 'User banned successfully'];
        } else {
            $user->status = 1;
            $user->ban_reason = null;
            $notify[] = ['success', 'User unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);
    }


    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.users.detail', $user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->username;
        return view('admin.users.notification_single', compact('pageTitle', 'user'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        notify($user, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }
        $users = User::where('ev', 1)->where('status', 1)->count();
        $pageTitle = 'Notification to Verified Users';
        return view('admin.users.notification_all', compact('pageTitle', 'users'));
    }

    public function sendNotificationAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = User::where('status', 1)->where('ev', 1)->skip($request->skip)->first();

        notify($user, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => 'message sent',
            'total_sent' => $request->skip + 1,
        ]);
    }

    public function notificationLog($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $user->username;
        $logs = NotificationLog::where('user_id', $id)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'user'));
    }
}
