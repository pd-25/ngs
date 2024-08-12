<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Rooms';
        $rooms = $this->roomData();
        $roomTypes = RoomType::get();
        return view('admin.hotel.room_list', compact('pageTitle', 'rooms', 'roomTypes'));
    }

    public function status($id)
    {
        $room = Room::findOrFail($id);
        $room->status = $room->status ? 0 : 1;
        $room->save();
        if ($room->status) {
            $message = 'Room enabled successfully';
        } else {
            $message = 'Room disabled successfully';
        }
        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    protected function roomData()
    {
        $query = Room::query();

        if(request()->room_number){
            $roomNumber = request()->room_number;
            $query = $query->where('room_number', $roomNumber);
        }

        if (request()->room_type) {
            $roomType = request()->room_type;
            $query = $query->whereHas('roomType', function ($q) use ($roomType) {
                $q->where('id', $roomType);
            });
        }

        if (request()->status) {
            $scope = request()->status;
            $query = $query->$scope();
        }

        return $query->with('roomType')->orderBy('room_number', 'asc')->paginate(getPaginate());
    }
}
