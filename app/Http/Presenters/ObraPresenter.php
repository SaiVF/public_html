<?php

namespace App\Http\Presenters;

use App\Obra;
use McCool\LaravelAutoPresenter\BasePresenter;

class ObraPresenter extends BasePresenter
{
  public function latLng()
  {
    return explode(',', $this->ubicacion);
  }

  public function lat()
  {
    return trim($this->latlng[0]);
  }
  public function lng()
  {
    return trim($this->latlng[1]);
  }
}