<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking ;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PendingPaymentController extends Controller
{
    

    public function index()
    {
        $pageTitle = 'All Expense';
        $bookings = $this->bookingData();
        return view('admin.pending.payment', compact('pageTitle', 'bookings'));
    }

    protected function bookingData()
    {
        $request = request();
        $query = Booking::query();

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('mobile', 'like', "%$search%");
            })->orWhere(function ($query) use ($search) {
                $query->where('guest_details->name', 'like', "%$search%")
                    ->orWhere('guest_details->email', 'like', "%$search%")
                    ->orWhere('guest_details->mobile', 'like', "%$search%")
                    ->orWhere('booking_number', 'like', "%" . $search . "%");
            });
        }

        if ($request->date) {
            $date = explode('-', $request->date);

            $request->merge([
                'checkin_date' => trim(@$date[0]),
                'checkout_date' => trim(@$date[1]) ? trim(@$date[1]) : trim(@$date[0])
            ]);

            $request->validate([
                'checkin_date' => 'required|date_format:m/d/Y',
                'checkout_date' => 'nullable|date_format:m/d/Y|after_or_equal:checkin_date'
            ]);

            $checkIn = Carbon::parse($request->checkin_date)->format('Y-m-d');
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
            ->latest()
            ->get();
            //->paginate(getPaginate());
    }

    public function store(Request $request, $id=null)
    {
        $validation_rule = [
            'category_name'     => 'required',
           
         
        ];
// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $expance = new Expance();
            $notify[] = ['success', 'Expance Created Successfully'];
        }else{
            $expance = Expance::findOrFail($id);
            $notify[] = ['success', 'Expance Updated Successfully'];
        }
        $request->validate($validation_rule,[
            'category_name'     => 'required',
            

        ]);


        $expance->category_name             = $request->category_name;
          
        $expance->save();

        return redirect()->back()->withNotify($notify);
    }

    protected function validateRecipient($request, $id)
    {
        $rules = [
            'category_name'     => 'required',
            

        ];

        $request->validate($rules);
    }


    public function remove($id)
    {
        $expance = Expance::findOrFail($id);
        
        
        $expance->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    
    
}
