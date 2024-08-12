<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BookingRequest extends Model
{
    protected $fillable = ['id'];

    protected $casts = [
        'room_type_details' => 'object'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }

    //scope
    public function scopeInitial($query){
        return $query->where('status', 0);
    }

    public function scopeApproved($query){
        return $query->where('status', 2);
    }

    public function scopeCancelled($query){
        return $query->where('status', 3);
    }

    public function statusBadge(): Attribute
    {
        $className = 'badge badge--';
        if ($this->status == 0) {
            $className .= 'warning';
            $text = 'Pending';
        } elseif ($this->status == 1) {
            $className .= 'success';
            $text = 'Approved';
        } elseif ($this->status == 3) {
            $className .= 'danger';
            $text = 'Cancelled';
        }

        return new Attribute(
            get: fn () => "<span class='badge badge--$className'>" . trans($text) . "</span>",
        );
    }
}
