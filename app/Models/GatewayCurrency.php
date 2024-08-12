<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayCurrency extends Model
{
    protected $casts = ['status' => 'boolean'];

    // Relation
    public function method()
    {
        return $this->belongsTo(Gateway::class, 'method_code', 'code');
    }

    public function currencyIdentifier()
    {
        return $this->name ?? $this->method->name . ' ' . $this->currency;
    }

    public function scopeBaseCurrency()
    {
        return $this->method->crypto == 1 ? 'USD' : $this->currency;
    }

    public function scopeBaseSymbol()
    {
        return $this->method->crypto == 1 ? '$' : $this->symbol;
    }

    public function scopeMethodImage()
    {
        $image = null;
        if ($this->image) {
            $image = getImage(getFilePath('gateway') .'/' . $this->image,getFileSize('gateway'));
        }else{
            if ($this->method->image) {
                $image =  getImage(getFilePath('gateway') . '/' . $this->method->image,getFileSize('gateway'));
            }else{
                $image = getImage('/',getFileSize('gateway'));
            }
        }
        return $image;
    }

}
