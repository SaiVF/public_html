<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Child extends Model
{
  protected $fillable = [
  	'type',
  	'parent_id',
  	'title',
  	'excerpt',
  	'content',
  	'url',
  	'url_text',
  	'src',
  	'background',
  	'order',
    'category',
    'attr'
	];

  public function parent() {
    return DB::table(config('cms.types')[$this->attributes['type']])
    ->select('*')
    ->where('id', $this->attributes['parent_id'])
    ->first();
  }
}
