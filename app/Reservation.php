<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable = [
      'id_user','id_space','reservation_datetime','total_pax','total_payment','payment_status','discount','special_notes','created_at','updated_at','tax','bank_fee','reservation_code'
    ];

    public function user(){
      return $this->belongsTo('App\User','id_user');
    }
    public function space(){
      return $this->belongsTo('App\Space','id_space');
    }
    public function detailReservation(){
        return $this->belongsToMany('App\Menu', 'detail_reservation', 'id_reservation', 'id_menu')
          ->withPivot([
            'qty'
          ])
          ->withTimestamps();
    }
}
