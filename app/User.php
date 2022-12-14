<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','company_name','gst','phone','address','user_notes','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($pass){

        return $this->attributes['password'] = Hash::needsRehash($pass) ? Hash::make($pass) : $pass;
        
        }
        

        public function shipment(){
            return $this->hasMany(Shipment::class, 'bill_to_id','id');
        }

        public function quote(){
            return $this->hasMany(Quote::class, 'customer_id','id');
        }

        public function payments(){
            return $this->hasMany(Payment::class, 'customer_id','id');
        }

        public function receiver(){
            return $this->hasMany(Shipment::class, 'receiver_id');
        }

        
        public function vendor_details(){
            return $this->hasMany(ShipmentVendorDetail::class,'vendor_id');
        }

}
