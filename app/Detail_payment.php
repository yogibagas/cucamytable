<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_payment extends Model
{
    //

    protected $fillable = ['id_reservation','brand'];


        public function reservation(){
          return $this->belongsTo('App\Reservation','id_reservation');
        }
}
