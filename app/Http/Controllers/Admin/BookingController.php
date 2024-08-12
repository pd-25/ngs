<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Traits\ManageBooking;
use Illuminate\Http\Request;
use App\Models\BookedRoom;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{
    use ManageBooking;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user();
            return $next($request);
        });
        $this->userType = "admin";
        $this->column = "admin_id";
    }
    
    public function update_room(Request $request)
    {
        $room = $request->room;
        $id = $request->id;
        $booking_id = $request->booking_id;
        $all = $request->all;
        $roomData = Room::where('room_number', $room)->first();
        
        $mainBooking = Booking::where('id', $booking_id)->first();
        
        if($all == "yes"){
             
                $allData = BookedRoom::where('booking_id', $booking_id)->get();
                
                foreach($allData as $row){
                    $bookedRoomData = BookedRoom::where('booked_for', $roomData->booked_for)->where('room_id',$roomData->id)->whereNotIn('id', [$row->id])->first();
                    if($bookedRoomData){
                        $notification = $roomData->booked_for.' date is already in use';
                        $notify[] = ['error', $notification];
                        return back()->withNotify($notify);
                        exit();
                    }else{
                        
                        BookedRoom::where('id', $row->id)
                       ->update([
                           'room_id' =>$roomData->id
                        ]);
          
                        
                    }
                }
                
                if($mainBooking){
                    Booking::where('id', $booking_id)
                   ->update([
                       'room_number' => $room
                    ]);
                }
                
                $notification = 'Date updated successfully';
                $notify[] = ['success', $notification];
                return back()->withNotify($notify);
            
        }else{
             
            $bookedRoomData = BookedRoom::where('booked_for', $date)->where('room_id',$roomData->id)->whereNotIn('id', [$id])->first();
             
            if($bookedRoomData){
                $notification = 'Date is already in use';
                $notify[] = ['error', $notification];
                return back()->withNotify($notify);
            }else{
                
                BookedRoom::where('id', $id)
               ->update([
                   'room_id' =>$roomData->id
                ]);
    
                if($mainBooking){
                    Booking::where('id', $booking_id)
                   ->update([
                       'room_number' => $room
                    ]);
                }
                
                $notification = 'Date updated successfully';
                $notify[] = ['success', $notification];
                return back()->withNotify($notify);
            }
        }
    }
    public function mobile(Request $request)
    {
        $UserData = User::where('mobile', $request->mobile)->first();
        echo json_encode($UserData);
    }
}
