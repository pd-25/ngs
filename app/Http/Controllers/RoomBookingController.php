<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\BookingRequest;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Course;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Subscriber;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Textmagic\Services\Models\Templates;
use Artisan;
class RoomBookingController extends Controller
{
    public function index(){
        $pageTitle = 'Room Booking';
        return view($this->activeTemplate . 'sections.room_booking',compact('pageTitle','pageTitle'));
    }
}