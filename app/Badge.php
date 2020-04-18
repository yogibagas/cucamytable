<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    //
    protected $fillable = [
        'name', 'image', 'status','id_user'
    ];
}
