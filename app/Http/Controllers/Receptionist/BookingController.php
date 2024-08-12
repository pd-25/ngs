<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ManageBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ManageBooking;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('receptionist')->user();
            return $next($request);
        });
        $this->userType = "receptionist";
        $this->column = "receptionist_id";
    }

    public function mobile(Request $request)
    {
        $UserData = User::where('mobile', $request->mobile)->first();
        echo json_encode($UserData);
    }

   
}
