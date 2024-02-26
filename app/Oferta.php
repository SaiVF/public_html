<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Oferta extends Model
{
  protected $fillable = [
    'title',
    'fecha_inicio',
    'fecha_limite',
    'lugar',
    'lugar_aplicar',
    'descripcion',
    'requisito',
    'obs',
    'url',
    'precio',
    'pais_id',
    'featured',
    'owner',
    'last_edit',
    'state',
    'inicio_aplicacion',
    'cierre_aplicacion',
    'departamento',
    'ciudad',
    'contacto_con',
    'proceso_aplicacion',
    'uri_aplicacion',
    'nivel',
    'tema',
    'tiempo',
    'vacancias_disponibles',
    'beneficios',
    'modalidad'
  ];
  protected $primaryKey = 'id';

  public function categories()
  {
      return $this->belongsToMany('App\Category', 'categories_relationships', 'parent_id', 'category_id');
  }

  public function theCategories() {
    $categories = DB::table('categories_relationships')->where([
      ['parent_id', $this->attributes['id']],
      ['type', 3]
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

  public function setFeaturedAttribute($value)
  {
    $this->attributes['featured'] = !empty($value) ? 1 : 0;
  }

  public function setOwnerAttribute()
  {
    $this->attributes['owner'] = Auth::user()->id;
  }

  public function setPriceAttribute($value)
  {
    $this->attributes['price'] = str_replace('.', '', $value);
  }

  public function setNewPriceAttribute($value)
  {
    $this->attributes['new_price'] = str_replace('.', '', $value);
  }

  public function theCategory() {
    $categories = DB::table('categories_relationships')->where([
      ['parent_id', $this->attributes['id']],
      ['type', 3]
    ])->get();
    if(!$categories->isEmpty()) return \App\Category::where('id', $categories->first()->category_id)->first();
  }


  public function theColor($type = NULL) {
    $categories = DB::table('categories_relationships')->where([
      ['parent_id', $this->attributes['id']],
      ['type', 3]
    ])->get();
    if(!$categories->isEmpty()) {
      $category = \App\Category::where('id', $categories->first()->category_id)->first();
      if ($category->parent) {
        $category = \App\Category::where('id', $category->parent)->first();
      }

      return $type == 'fondo' ? $category->color : $category->color_principal;
    }
  }

  public function theIcon() {
      $categories = DB::table('categories_relationships')->where([
        ['parent_id', $this->attributes['id']],
        ['type', 3]
      ])->get();
      
      $category = \App\Category::where('id', $categories->first()->category_id)->first();
      if ($category->parent) {
        $category = \App\Category::where('id', $category->parent)->first();
      }
      
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

  public function children() {
    return $this->hasMany('App\Child', 'parent_id', 'id');
  }

  public function theDateInicio() {
    return date('d/m/Y', strtotime($this->fecha_inicio));
  }
  public function theDate() {
    return date('d/m/Y', strtotime($this->fecha_limite));
  }
  public function theDateAplicacionInicio() {
    return date('d/m/Y', strtotime($this->inicio_aplicacion));
  }
  public function theDateAplicacionCierre() {
    return date('d/m/Y', strtotime($this->cierre_aplicacion));
  }


  

  public function theMarca() {
    return $this->belongsTo('App\Category', 'marca', 'id');
  }

  public function theChildren() {
    return $this->children()->where('type', 3)->orderBy('order')->get();
  }

  public function pais()
  {
    return $this->belongsTo('App\Pais', 'pais_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'owner', 'id');
  }

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = trim($value);
  }

  public function related() {
    $productos_id = DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', '!=', $this->attributes['id']],
    //  ['category_id', $this->theCategory()->id]
    ])->pluck('parent_id');
    return $this->whereIn('id', $productos_id)->orderBy('order')->get();
  }

  public function isVencida()
  {
    $hoy = \Carbon\Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    if (!empty($this->attributes['fecha_limite'])) {
      return $this->attributes['fecha_limite'] < $hoy;
    }else {
      return false;
    }
    
  }
  public function theModalidad() {
    $modalidad = config('cms.modalidad');
    return  $this->attributes['modalidad'] ? $modalidad[$this->attributes['modalidad']] : '';
  }
}