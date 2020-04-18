<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point_log extends Model
{
    //
    protected $fillable = ['id_user','points','desc'];


        public function user(){
          return $this->belongsTo('App\User','id_user');
        }
}
