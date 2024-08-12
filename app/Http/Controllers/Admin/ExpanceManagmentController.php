<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpanceManagment;
use App\Models\Expance;
use App\Models\Booking;
use App\Models\BookedRoom;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\UsedExtraService;
use App\Models\ExtraService;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;


class ExpanceManagmentController extends Controller
{
        protected $userType;

    public function index()
    {
        $pageTitle     = 'All Expenses ';
        $data = ExpanceManagment::all();
            $table2Data = Expance::all();
        return view('admin.expance.add_expance_managment', compact('pageTitle', 'data','table2Data')); 

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
    $pageTitle = 'Booking Status';
    
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
    
    $UsedServices = $rooms->pluck('used_extra_services.id')->toArray();
   
    $bookedRooms = $rooms->pluck('room.id')->toArray();

    $emptyRooms = Room::whereNotIn('id', $bookedRooms)
        ->with('roomType:id,name')
        ->select('id', 'room_type_id', 'room_number')
        ->get();
        
        $UsedExtraService = UsedExtraService::where('service_date',$selectedDate)->get();
        $ExtraService = ExtraService::where('status',1)->get();
        
       
         $totalRooms_1 = RoomType::where('id', 1)->first();
         $totalRooms_2 = RoomType::where('id', 2)->first();
         $totalRooms_3 = RoomType::where('id', 3)->first();
         
          $occupiedRooms_1 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 1)->count();
          $occupiedRooms_2 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 2)->count();
          $occupiedRooms_3 = Room::whereNotIn('id', $bookedRooms)->where('room_type_id', 3)->count();
         
        

    return view($this->userType . '.admin.booking.booking_availability', compact('pageTitle', 'rooms', 'emptyRooms', 'selectedDate','totalRooms_1','totalRooms_2', 'totalRooms_3', 'occupiedRooms_1', 'occupiedRooms_2', 'occupiedRooms_3','ExtraService','selectedDate'));
}






       
    
}
