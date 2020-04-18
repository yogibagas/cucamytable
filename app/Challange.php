<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challange extends Model
{
    //
    protected $fillable = [
        'id_reward','is_multiple','type','min_transaction','reservation_date','reservation_required','status','is_multiple_reservation','tota_spend','id_user','reservation_status','total_spend'
    ];

    public function reward(){
        return $this->belongsTo('App\Reward','id_reward');
    }
}
