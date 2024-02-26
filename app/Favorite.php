<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Favorite extends Model
{
  protected $table = 'favorites';



  /*public function oferta() {
    return $this->hasMany('App\Oferta', 'id', 'id');
  }*/
  public function oferta()
  {
    return $this->belongsTo('App\Oferta', 'oferta_id', 'id');
  }

}