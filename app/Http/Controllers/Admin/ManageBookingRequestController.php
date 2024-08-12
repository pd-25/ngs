<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ManageBookingRequest;

class ManageBookingRequestController extends Controller
{
    use ManageBookingRequest;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user();
            return $next($request);
        });
        $this->column = "admin_id";
        $this->userType = "admin";
    }
}
