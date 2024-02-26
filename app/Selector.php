<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selector extends Model
{
  protected $table = 'select';
  protected $fillable = [
    'title',
    'type',
    'category_id'
  ];

  public function category()
  {
    return $this->belongsTo('App\Category', 'category_id', 'id');
  }
}