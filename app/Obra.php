<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Presenters\ObraPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Carbon\Carbon;
use DB;
class Obra extends Model implements HasPresenter
{
  protected $fillable = [
    'nombre',
    'lugar',
    'inicio',
    'cierre',
    'cierre_final',
    'ubicacion',
    'ingeniero',
    'administrador',
  ];

  public function getPresenterClass()
  {
    return ObraPresenter::class;
  }

  public function equipos()
  {
    $equipos_id = DB::table('obras_relationships')->where('obra_id', $this->attributes['id'])->pluck('equipo_id');
    return \App\Equipo::whereIn('id', $equipos_id)->orderBy('marca')->get();
  }

  public function getInicioAttribute()
  {
    if(!empty($this->attributes['inicio'])) return Carbon::createFromFormat('Y-m-d', $this->attributes['inicio'])->format('d/m/Y');
  }

  public function setInicioAttribute($value)
  {
    if($value) $this->attributes['inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }

  public function getCierreAttribute()
  {
    if(!empty($this->attributes['cierre'])) return Carbon::createFromFormat('Y-m-d', $this->attributes['cierre'])->format('d/m/Y');
  }

  public function setCierreAttribute($value)
  {
    if($value) $this->attributes['cierre'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }

  public function getCierreFinalAttribute()
  {
    if(!empty($this->attributes['cierre_final'])) return Carbon::createFromFormat('Y-m-d', $this->attributes['cierre_final'])->format('d/m/Y');
  }

  public function setCierreFinalAttribute($value)
  {
    if($value) $this->attributes['cierre_final'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }
}