<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Challange_log extends Model
{
    //
    protected $primaryKey = ['id_challange', 'id_user'];
      public $incrementing = false;
    protected $fillable = ['id_challange','id_user','notification_status','times_done'];

    protected function setKeysForSaveQuery(Builder $query)
   {
       $query
           ->where('id_challange', '=', $this->getAttribute('id_challange'))
           ->where('id_user', '=', $this->getAttribute('id_user'));

       return $query;
   }
}
