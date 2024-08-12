<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpanceManagment;
use App\Models\Expance;
use App\Models\Booking;
use App\Models\BookedRoom;
use App\Models\RoomType;
use App\Models\Room;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class ExpanceManagmentController extends Controller
{
        protected $userType;

    public function index()
    {
      
       
        $pageTitle     = 'All Expenses ';
        $data = ExpanceManagment::where('user_id', auth()->guard('receptionist')->id())->get();
         $table2Data = Expance::all();
     
        return view('receptionist.expance.add_expance_managment', compact('pageTitle', 'data','table2Data')); 

    }
    
    public function report(){
        $pageTitle = 'All Expense';
        $data = ExpanceManagment::all();
       
        $table2Data = $this->bookingData('ALL');
      
        $users = Booking::all();
        $user_id= 0;
        return view('receptionist.expance.expance_report', compact('pageTitle', 'data', 'table2Data', 'users', 'user_id'));
    }
    
     public function filter_by_date(Request $request)
    {
        $pageTitle = 'All Expense';
        $data = ExpanceManagment::all();
       
        $table2Data = $this->bookingData('ALL');
      
        $users = Booking::all();
        $user_id= 0;
        return view('receptionist.expance.expance_report', compact('pageTitle', 'data', 'table2Data', 'users', 'user_id'));
    }
    
     public function filter_by_user(Request $request){
       
        $pageTitle = 'All Expense';
        $data = ExpanceManagment::all();
       
        $table2Data = $this->bookingData('ALL');
      
      
        $users = Booking::all();
        if($request->id){
            $user_id = $request->id;
        }else{
            $user_id= 0;
        }
      
        return view('receptionist.expance.expance_report', compact('pageTitle', 'data', 'table2Data', 'users', 'user_id'));
    }
    

    public function store(Request $request, $id=null)
    {
        $validation_rule = [
        'debit' => 'required|numeric',
        'credit' => 'required',
        'date' => 'required',
        'particulars' => 'required',
        'expense_type' => 'required',
        'expense_category' => 'required'
    ];

// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $expance = new ExpanceManagment();
            $notify[] = ['success', 'Expense Created Successfully'];
        }else{
            $expance = ExpanceManagment::findOrFail($id);
            $notify[] = ['success', 'Expense Updated Successfully'];
        }
       $request->validate($validation_rule, [
        'debit.required' => 'Debit field is required',
        'debit.numeric' => 'Debit field must contain only digits',
        'credit.required' => 'Credit field is required',
        'date.required' => 'Date field is required',
        'particulars.required' => 'Particulars field is required',
        'expense_type.required' => 'Expense type field is required',
        'expense_category.required' => 'Expense category field is required'
    ]);


        $expance->debit             = $request->debit;
        $expance->credit             = $request->credit;
        $expance->date             = $request->date;
        $expance->particulars             = $request->particulars;
        $expance->expense_type             = $request->expense_type;
        $expance->expense_category             = $request->expense_category;
        $expance->user_id             = $request->user_id;

        $expance->save();

        return redirect()->back()->withNotify($notify);
    }

    protected function validateRecipient($request, $id)
    {
        $rules = [
             'debit'     => 'required',
            'credit'     => 'required',
            'date'     => 'required',
            'particulars'     => 'required',
            'expense_type'     => 'required',
            'expense_category'     => 'required'


        ];

        $request->validate($rules);
    }


    public function remove($id)
    {
        $expance = ExpanceManagment::findOrFail($id);
        
        
        $expance->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    
    


public function view(Request $request)
{
    $pageTitle = 'Available Rooms for Booking';
    
    // Get the selected date from the input
    $selectedDate = $request->input('selected_date', now()->toDateString());
    
    $rooms = BookedRoom::active()
        ->with([
            'room:id,room_number,room_type_id',
            'room.roomType:id,name',
            'booking:id,user_id,booking_number',
            'booking.user:id,firstname,lastname',
            'extraServices.extraService:id,name'
        ])
        ->where('booked_for', $selectedDate)
        ->get();
    
    $bookedRooms = $rooms->pluck('room.id')->toArray();

    $emptyRooms = Room::whereNotIn('id', $bookedRooms)
        ->with('roomType:id,name')
        ->select('id', 'room_type_id', 'room_number')
        ->get();

    return view($this->userType . '.admin.booking.booking_availability', compact('pageTitle', 'rooms', 'emptyRooms', 'selectedDate'));
}


   protected function bookingData($scope)
    {
        $request = request();
        $query = Booking::query();

        if ($scope != "ALL") {
            $query = $query->$scope();
        }

        if ($request->search) {
            $search = $request->search;
           
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like',  "%$search%")
                    ->orWhere('mobile', 'like',  "%$search%");
            })->orWhere(function ($query) use ($search) {
                $query->where('guest_details->name', 'like', "%$search%")
                    ->orWhere('guest_details->email', 'like', "%$search%")
                    ->orWhere('guest_details->mobile', 'like', "%$search%")
                    ->orWhere('booking_number', 'like', "%" . $search . "%");
            });
        }

        if ($request->date) {
            $date  = explode('-', $request->date);

            $request->merge([
                'checkin_date'  => trim(@$date[0]),
                'checkout_date' => trim(@$date[1]) ? trim(@$date[1]) : trim(@$date[0])
            ]);

            $request->validate([
                'checkin_date'  => 'required|date_format:m/d/Y',
                'checkout_date' => 'nullable|date_format:m/d/Y|after_or_equal:checkin_date'
            ]);

            $checkIn  = Carbon::parse($request->checkin_date)->format('Y-m-d');
            $checkOut = Carbon::parse($request->checkout_date)->format('Y-m-d');

            $query->whereHas('bookedRoom', function ($q) use ($checkIn, $checkOut) {
                $q->where('booked_for', '>=', $checkIn)->where('booked_for', '<=', $checkOut);
            });
        }
           
        return $query->with('bookedRoom.room', 'user')
            ->withMin('bookedRoom', 'booked_for')
            ->withMax('bookedRoom', 'booked_for')
            ->withSum('usedExtraService', 'total_amount')
            ->orderBy('booked_room_min_booked_for', 'asc')
            ->latest()->where('user_id', auth()->guard('receptionist')->id())
            ->paginate(getPaginate());
    }



       
    
}
