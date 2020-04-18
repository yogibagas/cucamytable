<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge_log extends Model
{
    //
    protected $fillable = ['id_user','id_badge','description'];

    public function user(){
      return $this->belongsTo('App\User','id_user');
    }


}
