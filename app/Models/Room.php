<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Room extends Model
{
    protected $fillable = ['id'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function booked()
    {
        return $this->hasMany(BookedRoom::class, 'room_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', 0);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';

        if($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Enabled').'</span>';
        }else{
            $html = '<span><span class="badge badge--danger">'.trans('Disabled').'</span></span>';
        }

        return $html;
    }
}
