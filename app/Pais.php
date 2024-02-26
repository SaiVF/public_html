<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pais extends Model
{
  protected $table = 'paises';
  protected $fillable = [
    'nombre',
    'name',
    'nom',
    'iso2',
    'iso3',
    'icon',
  ];

}