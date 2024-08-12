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
class SiteController extends Controller
{
    public function index()
    {
      //  Artisan::call('cache:clear');
       // dd("ddd");
        $pageTitle = 'Home';
        $coursedata = Course::all();
        $eventdata = Event::all();
        $gallerydata = Gallery::all();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections','coursedata','eventdata','gallerydata'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function faq()
    {
        $pageTitle = 'Frequently Asked Question';
        $faqElements = Frontend::where('data_keys', 'faq.element')->orderBy('id', 'desc')->get();
        return view($this->activeTemplate . 'faq', compact('pageTitle', 'faqElements'));
    }

    public function blog()
    {
        $pageTitle = 'Latest Updates';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(9));
        return view($this->activeTemplate . 'blog', compact('pageTitle', 'blogs'));
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = "Read Full Article";
        $blogLists = Frontend::where('data_keys', 'blog.element')->where('id', '!=', $id)->orderBy('id', 'desc')->limit(10)->get();

        $seoContents['keywords']           = $blog->meta_keywords ?? [];
        $seoContents['social_title']       = $blog->data_values->title;
        $seoContents['description']        = strip_tags($blog->data_values->description);
        $seoContents['social_description'] = strip_tags($blog->data_values->description);
        $seoContents['image']              = getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '1000x700');
        $seoContents['image_size']         = '1000x700';

        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'blogLists', 'seoContents'));
    }

    public function contact()
    {
        $pageTitle   = "Contact Us";
        $contactCon  = getContent('contact_us.content', true);
        $socialElements = getContent('social_icon.element', false, null, true);
        $sections    = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->firstOrFail();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'contactCon', 'socialElements', 'sections'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function roomTypes()
    {
        $pageTitle = 'Room Types';
        $roomTypes = RoomType::active()->with('images', 'amenities')->with(['images', 'amenities'])->get();
        return view($this->activeTemplate . 'room.types', compact('pageTitle', 'roomTypes'));
    }

    protected function filterRoomType(Request $request)
    {
        $pageTitle = 'Room Types';
        $roomTypes = RoomType::active();
        $date      = explode('-', $request->date);

        $request->merge([
            'check_in'  => trim(@$date[0]),
            'check_out' => trim(@$date[1]),
        ]);

        $validator = Validator::make($request->all(), [
            'check_in'  => 'required|date_format:m/d/Y|after:yesterday',
            'check_out' => 'nullable|date_format:m/d/Y|after:check_in',
        ]);

        if ($request->check_in || $request->check_out) {
            if ($request->check_in) {
                if (Carbon::now()->format('Y-m-d') > Carbon::parse($request->check_in)->format('Y-m-d')) {
                    $notify[] = ['error', 'Check In date can\'t be less than current date'];
                    return back()->withNotify($notify);
                }
            }

            if ($request->check_out) {
                if (Carbon::now()->format('Y-m-d') > Carbon::parse($request->check_out)->format('Y-m-d')) {
                    $notify[] = ['error', 'Check Out date can\'t be less than current date'];
                    return back()->withNotify($notify);
                }

                if ($request->check_in) {
                    if (Carbon::parse($request->check_out)->format('Y-m-d') < Carbon::parse($request->check_in)->format('Y-m-d')) {
                        $notify[] = ['error', 'Check Out date can\'t be less than check in date'];
                        return back()->withNotify($notify);
                    }
                } else {
                    $notify[] = ['error', 'Check In date can\'t be empty'];
                    return back()->withNotify($notify);
                }
            }


            $roomTypes = $roomTypes->whereHas('rooms', function ($room) use ($request) {
                $room->active()->whereNot(function ($room) use ($request) {
                    $room->whereHas('booked', function ($booked) use ($request) {
                        $booked->active()
                            ->when(
                                $request->check_out != "",
                                function ($query) use ($request) {
                                    $query->where(function ($query) use ($request) {
                                        $query->whereBetween('booked_for', [Carbon::parse($request->check_in)->format('Y-m-d'), Carbon::parse($request->check_out)->format('Y-m-d')]);
                                    });
                                },
                                function ($query) use ($request) {
                                    $query->whereDate('booked_for', Carbon::parse($request->check_in)->format('Y-m-d'));
                                }
                            );
                    });
                });
            });
        }

        if ($request->total_adult) {
            $roomTypes = $roomTypes->where('total_adult', '>=', $request->total_adult);
        }
        if ($request->total_child) {
            $roomTypes = $roomTypes->where('total_child', '>=', $request->total_child);
        }


        $roomTypes    = $roomTypes->with('images', 'amenities')->paginate(getPaginate(6));

        if ($request->banner_form) {
            $roomType = RoomType::active()->with(['rooms' => function ($room) {
                $room->active();
            }])->get();

            return view($this->activeTemplate . 'room.types', compact('pageTitle', 'roomTypes'));
        }
    }


    public function roomTypeDetails($id, $slug)
    {
        $roomType = RoomType::with('amenities', 'complements', 'images')->findOrFail($id);
        $pageTitle = $roomType->name;
        return view($this->activeTemplate . 'room.details', compact('pageTitle', 'roomType'));
    }

    public function sendBookingRequest(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|integer',
            'check_in' => 'required|date_format:m/d/Y|after:yesterday',
            'check_out' => 'nullable|date_format:m/d/Y|after_or_equal:check_in',
            'number_of_rooms' => 'required|integer:gt:0',
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);

        if (!auth()->check()) {
            session()->put('BOOKING_REQUEST', route('room.type.details', [$roomType->id, slug($roomType->name)]));
            return to_route('user.login');
        }

        $checkInDate   = Carbon::parse($request->check_in);
        $checkOutDate  = Carbon::parse($request->check_out);

        //Check limitation of number of rooms
        $availableRoom = $this->getMinimumAvailableRoom($request);

        if ($request->number_of_rooms > $availableRoom) {
            $notify[] = ['error', 'Number of rooms exceeds the limit'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        
        

            $bookingRequest                  = new BookingRequest();
            $bookingRequest->user_id         = $user->id;
            $bookingRequest->guest_type = $request->guest_type;
            $bookingRequest->name    = $request->name;
            $bookingRequest->check_in        = $checkInDate->format('Y-m-d');
            $bookingRequest->check_out       = $checkOutDate->format('Y-m-d');
            $bookingRequest->unit_fare       = $roomType->fare;
            $bookingRequest->email = $request->email;
			$bookingRequest->mobile = $request->mobile;
			$bookingRequest->c_d_c_number = $request->c_d_c_number;
			$bookingRequest->address = $request->address;
			$bookingRequest->state = $request->state;
			$bookingRequest->city = $request->city;
			$bookingRequest->pin_code = $request->pin_code;
			$bookingRequest->cheak_in_time = $request->cheak_in_time;
			$bookingRequest->paid_amount = $request->paid_amount;
			$bookingRequest->payment_mode = $request->payment_mode;
			$bookingRequest->number_of_rooms = $request->number_of_rooms;
			$bookingRequest->image = $request->image;


        $bookingRequest->total_amount    = $roomType->fare * $request->number_of_rooms * ($checkOutDate->diffInDays($checkInDate) + 1);
        // $bookingRequest->total_amount    = $request->total_amount;
        $bookingRequest->save();

        $notify[] = ['success', 'Booking request sent successfully'];
        return redirect()->route('user.booking.request.all')->withNotify($notify);
    }

    public function checkRoomAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required|exists:room_types,id',
            'check_in'     => 'required|date_format:m/d/Y|after:yesterday',
            'check_out'    => 'required|date_format:m/d/Y|after_or_equal:check_in'
        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $availableRoom = $this->getMinimumAvailableRoom($request);

        if (!$availableRoom) {
            return response()->json(['error' => 'No room available between these dates']);
        }

        return response()->json(['success' => $availableRoom]);
    }


    protected function getMinimumAvailableRoom($request)
    {

        $checkInDate           = Carbon::parse($request->check_in);
        $checkOutDate          = Carbon::parse($request->check_out);
        $dateWiseAvailableRoom = [];

        for ($checkInDate; $checkInDate <= $checkOutDate; $checkInDate->addDays()) {
            $checkIn = $checkInDate->format('Y-m-d');

            $bookedRoom = Room::where('room_type_id', $request->room_type_id)
                ->whereHas('booked', function ($booked) use ($checkIn) {
                    $booked->active()->whereDate('booked_for', $checkIn);
                })->get('id')->toArray();

            $dateWiseAvailableRoom[] = Room::active()->where('room_type_id', $request->room_type_id)->whereNotIn('id', $bookedRoom)->count();
        }

        return min($dateWiseAvailableRoom);
    }

    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:subscribers,email'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $newSubscriber = new Subscriber();
        $newSubscriber->email = $request->email;
        $newSubscriber->save();
        return response()->json(['success' => true, 'message' => 'Thanks for subscribing us.']);
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $basic = gs();
        if ($general->maintenance_mode == 0) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

   
    public function course(){
        $pageTitle = 'Course';
        $data = Course::all();
        return view($this->activeTemplate . 'sections.course',compact('pageTitle','data'));
    }
    public function event(){
        $pageTitle = 'Event';
        $data = Event::all();
        return view($this->activeTemplate . 'sections.event',compact('pageTitle','data'));
    }
    public function gallery(){
        $pageTitle = 'Gallery';
        $data = Gallery::all();
        return view($this->activeTemplate . 'sections.gallery',compact('pageTitle','data'));
    }
    public function single_course($id){
        $pageTitle = 'Single Course';
        $data = Course::find($id);
        return view($this->activeTemplate . 'sections.single_course',compact('pageTitle','data'));
    }
    public function abouts(){
        $pageTitle = 'About Us';
        $data = Course::all();
        return view($this->activeTemplate . 'sections.abouts',compact('pageTitle','data'));
    }
    public function about_maritime(){
        $pageTitle = 'About Maritime Academy';
        $data = Course::all();
        return view($this->activeTemplate . 'sections.about_maritime',compact('pageTitle','data'));
    }
    // public function single_course($id){
    //     $pageTitle = 'Maritime Academy';
    //     $data = Course::find($id);
    //     return view($this->activeTemplate . 'sections.new_course',compact('pageTitle','data'));
    // }

    public function filter_image_bycategory(Request $request){
        if($request->category_id == 0){
            $data = Gallery::all();
        }else{
            $data = Gallery::where('gallery_category', $request->category_id)->get();
        }
        
        return view($this->activeTemplate . 'sections.gallery_image',compact('data'));
    }





}
