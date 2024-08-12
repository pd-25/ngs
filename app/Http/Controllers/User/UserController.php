<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRequest;
use App\Models\Deposit;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {

        $user = auth()->user();
        $pageTitle = 'Dashboard';
        $pageTitle = 'Dashboard';
        $bookings  = Booking::where('user_id', $user->id)->with(
            'bookedRoom:id,booking_id,room_id,booked_for',
            'bookedRoom.room:id,room_type_id,room_number',
            'bookedRoom.room.roomType:id,name'
        )->latest()->limit(10)->paginate(10);

        $booking['total']          = Booking::where('user_id', $user->id)->count();
        $booking['successful']     = Booking::active()->where('user_id', $user->id)->count();
        $booking['cancelled']      = Booking::cancelled()->where('user_id', $user->id)->count();
        $booking['checkedOut']     = Booking::checkedOut()->where('user_id', $user->id)->count();
        $booking['request']        = BookingRequest::initial()->where('user_id', $user->id)->count();
        $booking['total_payment']  = Deposit::successful()->where('user_id', $user->id)->sum('amount');

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'booking', 'bookings'));
    }

    public function attachmentDownload($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);

        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }


    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = [
            'country'    => @$user->address->country,
            'address'    => $request->address,
            'state'      => $request->state,
            'zip'        => $request->zip,
            'city'       => $request->city,
        ];
        $user->reg_step  = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }
}
