<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class GlobalVars
{
  public function compose(View $view)
  {
    $i = 1;

    $view->with([
      'i' => $i,
    ]);
  }
}
