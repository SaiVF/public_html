<?php

namespace App\Http\Presenters;

use App\Post;
use Date;
use McCool\LaravelAutoPresenter\BasePresenter;

class PostPresenter extends BasePresenter
{
  public function isFeatured()
  {
    return $this->wrappedObject->featured ? 'info' : '';
  }

  public function theDate()
  {
    return Date::createFromFormat('d/m/Y H:i:s', $this->wrappedObject->published_at)->format('d F, Y');
  }

  public function formattedDate()
  {
    return Date::createFromFormat('d/m/Y H:i:s', $this->wrappedObject->published_at)->format('d/m/Y');
  }
}