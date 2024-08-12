<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'country_code',
        'mobile',
        'password',
        'address',
        'status',
        'ev',
        'sv',
        'reg_step',
        'ver_code',
        'ver_code_send_at',
        'tsc',
        'ban_reason',
        'remember_token',
        'created_at',
        'updated_at',
        'dob',
        'cdc',
        'rank'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function bookingRequest(){
        return $this->hasMany(BookingRequest::class)->where('status', 0);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', 0);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function bookingWithStatus($status){
        return $this->hasMany(Booking::class)->where('status', $status);
    }

    public function bookedRoom()
    {
        return $this->hasManyThrough(BookedRoom::class, Booking::class);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: function (){
                return $this->firstname . ' ' . $this->lastname;
            }
        );
    }

    // SCOPES
    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->where('ev', 0);
    }

    public function scopeMobileUnverified()
    {
        return $this->where('sv', 0);
    }

    public function scopeEmailVerified()
    {
        return $this->where('ev', 1);
    }

    public function scopeMobileVerified()
    {
        return $this->where('sv', 1);
    }

}
