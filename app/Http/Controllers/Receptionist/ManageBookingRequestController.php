<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Traits\ManageBookingRequest;

class ManageBookingRequestController extends Controller
{
    use ManageBookingRequest;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('receptionist')->user();
            return $next($request);
        });
        $this->userType = "receptionist";
        $this->column = "receptionist_id";
    }
}
