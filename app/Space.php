<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    //
    protected $fillable = [
        'name', 'maximum_pax', 'minimum_pax','image','desc','avaibility','status'
    ];
}
