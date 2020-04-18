<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
    protected $fillable = [
        'id_badge','point','max_point','point_type','status','id_user'
    ];
    public function badge(){
        return $this->belongsTo('App\Badge','id_badge');
    }
}
