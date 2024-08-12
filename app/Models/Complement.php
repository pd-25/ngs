<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Complement extends Model
{
    protected $casts = [
        'item' => 'array'
    ];
}
