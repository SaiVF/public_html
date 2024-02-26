<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Category extends Model
{
  protected $fillable = [
  	'name',
    'type',
  	'excerpt',
  	'content',
  	'image',
    'svg',
    'color',
    'color_principal',
    'related_words',
  	'type',
  	'order',
    'parent'
	];

  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim($value);
  }

  public function setParentAttribute($value)
  {
    $this->attributes['parent'] = !empty($value) ? $value : null;
  }

  public function theType() {
    $types = config('cms.types');
    return $types[$this->attributes['type']]['name'];
  }

  public function theParent() {
    $parent = self::findOrFail($this->attributes['parent']);
    if($parent) return $parent->name;
  }

  public function theColor() {
    $parent = self::findOrFail($this->attributes['parent']);
    if($parent) return $parent->color_principal;
  }

  public function theChildren() {
    return self::where('parent', $this->attributes['id'])->orderBy('order')->get();
  }

  public function hasChildren() {
    return $this->theChildren()->count();
  }

  public function isChild() {
    return $this->attributes['parent'];
  }

  public function productos() {
    return \App\Oferta::whereRaw(DB::raw('(SELECT category_id FROM categories_relationships WHERE parent_id = ofertas.id)'))->orderBy('title')->count();
  }

 
  public function ofertas()
  {
    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    return $this->belongsToMany('App\Oferta', 'categories_relationships', 'category_id', 'parent_id')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      });
  }


  public function item_count() {
    return $this->productos()->count() ? $this->productos()->count().' item'.($this->productos()->count() > 1 ? 's' : '') : null;
  }

  public function hasComercios() {
    return $this->comercios->count();
  }

  public function theIcon() {
    $category = \App\Category::where('id', $this->attributes['parent'])->first();

    if ($category) {
      if ($category->svg) {
        return '<svg id="'.str_slug($category->name).'" data-name="'.str_slug($category->name).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300">'.$category->svg.'</svg>' .'<style>svg#'.str_slug($category->name). ' .cls-1 {fill: '.$category->color_principal.'} </style>';
      }else {
        return '<img src="'.url('uploads/'.$category->image).'">';
      }
    }else {
      return '';
    }
  }
}

