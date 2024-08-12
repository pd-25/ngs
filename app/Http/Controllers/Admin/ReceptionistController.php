<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receptionist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ReceptionistController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Receptionists';

        $receptionists = Receptionist::query();

        if (request()->search) {
            $key = request()->search;
            $receptionists = $receptionists->where('name', 'LIKE', "%$key%")->orWhere('username', 'LIKE', "%$key%");
        }

        $receptionists = $receptionists->latest()->paginate(getPaginate());
        return view('admin.receptionist.index', compact('pageTitle', 'receptionists'));
    }

    public function save(Request $request, $id = 0)
    {
        $this->validateRecipient($request, $id);
        if ($id) {
            $receptionist         = Receptionist::findOrFail($id);
            $notification         = 'Receptionist updated successfully';
            $receptionist->status = $request->status ? 1 : 0;
        } else {
            $receptionist = new Receptionist();
            $notification = 'Receptionist added successfully';
        }

        $password  = $request->password;

        if ($password) {
            $receptionist->password = Hash::make($password);
        }

        $receptionist->name     = $request->name;
        $receptionist->username = $request->username;
        $receptionist->email    = $request->email;
        $receptionist->mobile   = $request->mobile;
        $receptionist->address  = $request->address ?? null;
        $receptionist->save();

        if (!$id) {
            notify($receptionist, 'ACCOUNT_CREATE', [
                'username' => $receptionist->username,
                'email' => $receptionist->email,
                'password' => $password
            ]);
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
    protected function validateRecipient($request, $id)
    {

        $passwordValidation = $id ? 'nullable' : 'required';

        $rules = [
            'name'     => 'required',
            'username' => 'required|string|unique:receptionists,username,' . $id,
            'email'    => 'required|email|unique:receptionists,email, ' . $id,
            'mobile'   => 'required|regex:/^([0-9]*)$/',
            'password' => [$passwordValidation, Password::min(8)],
        ];

        $request->validate($rules);
    }
    public function login($id)
    {
        Auth::guard('receptionist')->loginUsingId($id);
        return to_route('receptionist.dashboard');
    }
}
