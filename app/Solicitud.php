<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Solicitud extends Model
{
  protected $table = 'solicitud';
  protected $fillable = [
  	'mensaje',
    'user_id',
    'estado',
    'approved'
  ];

  public function usuario()
  {
    return $this->belongsTo('App\User', 'user_id', 'id');
  }

  public function approved()
  {
    return DB::table('users')->where('id', $this->attributes['approved'])->first();
  }



}