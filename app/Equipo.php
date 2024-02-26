<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Presenters\EquipoPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Carbon\Carbon;

class Equipo extends Model implements HasPresenter
{
  protected $fillable = [
    'obra',
    'codigo',
    'marca',
    'año',
    'chapa',
    'modelo',
    'ejes',
    'hp',
    'chasis',
    'capacidad_carga',
    'peso',
    'color',
    'altura',
    'ancho',
    'largo',
    'capacidad_tanque',
    'filtro_aceite',
    'filtro_combustible',
    'filtro_aire_primario',
    'filtro_aire_secundario',
    'aceite_motor',
    'aceite_caja',
    'herramientas_desgaste',
    'engrasador'
  ];

  public function theObra()
  {
    return $this->belongsTo('App\Obra', 'obra', 'id');
  }

  public function getPresenterClass()
  {
    return EquipoPresenter::class;
  }

  public function getInicioAttribute()
  {
    if($this->attributes['inicio']) return Carbon::createFromFormat('Y-m-d', $this->attributes['inicio'])->format('d/m/Y');
  }

  public function setInicioAttribute($value)
  {
    if($value) $this->attributes['inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }

  public function getCierreAttribute()
  {
    if($this->attributes['cierre']) return Carbon::createFromFormat('Y-m-d', $this->attributes['cierre'])->format('d/m/Y');
  }

  public function setCierreAttribute($value)
  {
    if($value) $this->attributes['cierre'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }

  public function getCierreFinalAttribute()
  {
    if($this->attributes['cierre_final']) return Carbon::createFromFormat('Y-m-d', $this->attributes['cierre_final'])->format('d/m/Y');
  }

  public function setCierreFinalAttribute($value)
  {
    if($value) $this->attributes['cierre_final'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }
}