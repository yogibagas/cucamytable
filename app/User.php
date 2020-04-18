<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','role','country_id','gender','phone','status'
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

    public function country(){
      return $this->belongsTo('App\Country');
    }
    public function points(){
      return $this->hasMany('App\Point_log','id_user');
    }
    public function badge(){
      return $this->hasMany('App\Badge_log','id_user');
    }

    public function reservation(){
      return $this->hasMany('App\Reservation','id_user');
    }
}
