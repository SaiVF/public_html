<?php
namespace App\Templates;

use App\Page;
use App\Category;
use App\Oferta;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;


class HomeTemplate extends AbstractTemplate
{
  protected $view = 'home';
  
  public function __construct(Page $pages, Category $categories)
  {
    $this->pages = $pages;
    $this->categories = $categories;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();
    $categories = $this->categories->whereNull('parent')->orderBy('order')->get();
    foreach($categories as $category) {
      foreach($category->theChildren() as $child) {
        $categorias[$category->name] = [
          $child->id => $child->name
        ];
      }
    }

    $ca       = Category::whereNull('parent')->get();
    $vencer   = Carbon::today()->addDays(7);
    $vencer   = $vencer->format('Y-m-d');

    $hoy      = Carbon::today();
    $hoy      = $hoy->format('Y-m-d');
    /*
    $ofertas  = //Oferta::where('state', 1)->where('featured', 1)->limit(24)->get();
                 Oferta::where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('featured', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(24)
                ->get();
    
    $nuevo    = Oferta::where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(12)
                ->get();

    $over     = Oferta::whereDate('fecha_limite', '<=', $vencer)
                ->whereDate('fecha_limite', '>=', $hoy)
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('fecha_limite', 'DESC')
                ->limit(12)
                ->get();
    */
    $minutes = 1440;
    Cookie::queue('popup', 'yes', $minutes);


    $view->with([
      'page' => $page,
      'categorias' => $categorias,
      'categories' => $categories,
      'ca'         => $ca,
      'hoy'        => $hoy
    ]);
  }
}