<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RoomType extends Model
{
    protected $casts = [
        'keywords' => 'array',
        'beds' => 'array'
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_type_amenities', 'room_type_id', 'amenities_id')->withTimestamps();
    }

    public function complements()
    {
        return $this->belongsToMany(Complement::class, 'room_type_complements', 'room_type_id', 'complement_id')->withTimestamps();
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasMany(RoomTypeImage::class);
    }

    //scope
    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeFeatured($query){
        return $query->where('feature_status', 1);
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

    public function featureBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->featureData(),
        );
    }

    public function featureData(){
        $html = '';

        if($this->feature_status == 1){
            $html = '<span class="badge badge--primary">'.trans('Featured').'</span>';
        }else{
            $html = '<span><span class="badge badge--dark">'.trans('Unfeatured').'</span></span>';
        }

        return $html;
    }
}
