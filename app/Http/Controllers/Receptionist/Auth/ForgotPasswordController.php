<?php

namespace App\Http\Controllers\Receptionist\Auth;

use App\Models\Receptionist;
use App\Models\ReceptionistPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('receptionist.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $pageTitle = 'Account Recovery';
        return view('receptionist.auth.passwords.email', compact('pageTitle'));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('receptionists');
    }

    public function sendResetCodeEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $receptionist = Receptionist::where('email', $request->email)->first();
        if (!$receptionist) {
            return back()->withErrors(['Email Not Available']);
        }

        $code = verificationCode(6);
        $receptionistPasswordReset = new ReceptionistPasswordReset();
        $receptionistPasswordReset->email = $receptionist->email;
        $receptionistPasswordReset->token = $code;
        $receptionistPasswordReset->status = 0;
        $receptionistPasswordReset->created_at = date("Y-m-d h:i:s");
        $receptionistPasswordReset->save();

        $receptionistIpInfo = getIpInfo();
        $receptionistBrowser = osBrowser();
        notify($receptionist, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => $receptionistBrowser['os_platform'],
            'browser' => $receptionistBrowser['browser'],
            'ip' => $receptionistIpInfo['ip'],
            'time' => $receptionistIpInfo['time']
        ], ['email'], false);

        $email = $receptionist->email;
        session()->put('pass_res_mail', $email);

        return to_route('receptionist.password.code.verify');
    }

    public function codeVerify()
    {
        $pageTitle = 'Verify Code';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error', 'Oops! session expired'];
            return to_route('receptionist.password.reset')->withNotify($notify);
        }
        return view('receptionist.auth.passwords.code_verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        $notify[] = ['success', 'You can change your password.'];
        $code = str_replace(' ', '', $request->code);
        return to_route('receptionist.password.reset.form', $code)->withNotify($notify);
    }
}
