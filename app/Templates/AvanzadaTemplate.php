<?php
namespace App\Templates;

use App\Page;
use App\Oferta;
use App\Category;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;

class AvanzadaTemplate extends AbstractTemplate
{
  protected $view = 'avanzada';
  
  public function __construct(Page $pages)
  {
    $this->pages = $pages;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();
    $categories = Category::whereNull('parent')->orderBy('name', 'DESC')->get();

    $ofertante = Oferta::groupBy('lugar_aplicar')->get();

    $view->with([
      'page' => $page,
      'ofertante' => $ofertante,
      'categories' => $categories,
    ]);
  }
}