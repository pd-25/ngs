<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExtraService extends Model
{
    public function scopeActive(){
        return $this->where('status', 1);
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
