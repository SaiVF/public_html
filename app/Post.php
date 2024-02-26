<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Date;

class Post extends Model
{
  protected $fillable = [
    'title',
    'excerpt',
    'content',
    'published_at',
    'featured',
    'visits',
    'author'
  ];
  
  public function getPublishedAtAttribute()
  {
    if(!empty($this->attributes['published_at'])) return date('d/m/Y H:i:s', strtotime($this->attributes['published_at']));
    return date('d/m/Y H:i:s');
  }

  public function setFeaturedAttribute($value)
  {
    $this->attributes['featured'] = !empty($value) ? 1 : 0;
  }

  public function setAuthorAttribute($value)
  {
    $this->attributes['author'] = !empty($value) ? $value : null;
  }

  public function setPublishedAtAttribute($value)
  {
    $datetime = explode(' ', trim($value));
    $published_at = date('Y-m-d', strtotime(str_replace('/', '-', $datetime[0]))).' '.$datetime[1];
    $this->attributes['published_at'] = $published_at;
  }

  public function children() {
    return $this->hasMany('App\Child', 'parent_id', 'id');
  }

  public function authors() {
    return $this->belongsTo('App\Category', 'author', 'id');
  }

  public function theCategory() {
    $categories = DB::table('categories_relationships')->where([
      ['parent_id', $this->attributes['id']],
      ['type', 2]
    ])->get();
    if(!$categories->isEmpty()) return \App\Category::where('id', $categories->first()->category_id)->first();
  }

  public function theCategories() {
    $categories = DB::table('categories_relationships')->where([
      ['parent_id', $this->attributes['id']],
      ['type', 2]
    ])->get();
    $categories_array = [];
    foreach($categories as $category) {
      $categories_array[] = $category->category_id;
    }
    if(!empty($categories_array)) {
      $categories = [];
      foreach($categories_array as $category) {
        $categories[] = \App\Category::where('id', $category)->value('name');
      }
      return implode(', ', $categories);
    }
  }

  public function theChildren() {
    return $this->children()->where('type', 2)->orderBy('order')->get();
  }

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = trim($value);
  }
  
  public function theDate()
  {
    return date('d/m/Y', strtotime($this->attributes['published_at']));
  }

  public function prettyDate()
  {
    return ucfirst(Date::parse($this->attributes['published_at'])->format('l j \d\e F \d\e Y, h:i'));
  }

  public function theExcerpt()
  {
    return strlen($this->attributes['excerpt']) >= 140 ? substr($this->attributes['excerpt'], 0, 140).' [...]' : $this->attributes['excerpt'];
  }
}