<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BookedRoom extends Model
{
    protected $guarded = ['id'];

    public function booking(){
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function extraServices(){
        return $this->hasMany(UsedExtraService::class);
    }

    //scope
    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeCheckedOut($query){
        return $query->where('status', 9);
    }

    public function scopeCancelled($query){
        return $query->where('status', 3);
    }


    public function statusBadge(): Attribute
    {
        $className = 'badge badge--';
        if ($this->status == 1) {
            $className .= 'success';
            $text = 'Booked';
        } elseif ($this->status == 3) {
            $className .= 'danger';
            $text = 'Cancelled';
        } elseif ($this->status == 9) {
            $className .= 'dark';
            $text = 'Checked Out';
        } else {
            $className .= 'warning';
            $text = 'Booking Request';
        }

        return new Attribute(
            get: fn () => "<span class='badge badge--$className'>" . trans($text) . "</span>",
        );
    }

}
