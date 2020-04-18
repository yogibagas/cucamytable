<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        'name', 'price', 'image_name', 'id_category' ,'status','id_user','desc'
    ];

    public function category(){
        return $this->belongsTo('App\MenuCategory','id_category');
    }

    public function detailReservation(){
        $this->belongsToMany('App\Reservation');
    }
}
