<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    protected $casts = [
        'guest_details' => 'object',
        'checked_out_at' => 'datetime'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingRequest()
    {
        return $this->hasOne(BookingRequest::class);
    }

    public function approvedBy()
    {
        return $this->hasOne(BookingActionHistory::class)->where('remark', 'approve_booking_request');
    }

    public function bookedBy()
    {
        return $this->hasOne(BookingActionHistory::class)->where('remark', 'book_room');
    }

    public function checkedOutBy()
    {
        return $this->hasOne(BookingActionHistory::class)->where('remark', 'checked_out');
    }

    public function cancelledBy()
    {
        return $this->hasOne(BookingActionHistory::class)->where('remark', 'cancel_booking');
    }

    public function bookedRoom()
    {
        return $this->hasMany(BookedRoom::class, 'booking_id');
    }

    public function usedExtraService()
    {
        return $this->hasMany(UsedExtraService::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentLog::class);
    }

     public function paymentlog()
    {
        return $this->hasMany(PaymentLog::class, 'booking_id');
    }

    //scope
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCheckedOut($query)
    {
        return $query->where('status', 9);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 3);
    }

    public function statusBadge(): Attribute
    {
        $className = 'badge badge--';

        if ($this->status == 1) {
            $className .= 'success';
            $text = 'Active';
        } elseif ($this->status == 3) {
            $className .= 'danger';
            $text = 'Cancelled';
        } elseif ($this->status == 9) {
            $className .= 'dark';
            $text = 'Checked Out';
        }

        return new Attribute(
            get: fn () => "<span class='badge badge--$className'>" . trans($text) . "</span>",
        );
    }
}
