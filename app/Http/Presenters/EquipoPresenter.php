<?php

namespace App\Http\Presenters;

use App\Equipo;
use McCool\LaravelAutoPresenter\BasePresenter;

class EquipoPresenter extends BasePresenter
{
  public function equipo()
  {
    return $this->marca.' '.$this->modelo.' '.$this->ano;
  }
}