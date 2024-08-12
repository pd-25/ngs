<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingActionHistory extends Model
{
    public function booking(){
        return $this->belongsTo(Booking::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function receptionist(){
        return $this->belongsTo(Receptionist::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
