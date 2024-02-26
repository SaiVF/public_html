<?php
namespace App\Templates;

use App\Page;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;
use App\Pais;
use App\Category;
use App\Oferta;

class PosteaTemplate extends AbstractTemplate
{
  protected $view = 'postea';
  
  public function __construct(Page $pages, Category $categories)
  {
    $this->pages = $pages;
    $this->categories = $categories;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();
    $ejes = Category::whereNull('parent')->orderBy('order', 'ASC')->pluck('name', 'id');
    $paises = Pais::pluck('nombre', 'id');
    $oferta = '';
    $categories = Category::whereNotNull('parent')->orderBy('order', 'ASC')->pluck('name', 'id');
    $departamentos = DB::table('departamentos')->pluck('nombre', 'nombre');
    $departamentos->prepend('Varios', 'Varios');
    $ciudades = DB::table('ciudades')->pluck('nombre', 'nombre');
    $ciudades->prepend('Varios', 'Varios');
    $modalidades = config('cms.modalidad');
    

    $view->with([
      'page'          => $page,
      'paises'        => $paises,
      'ejes'          => $ejes,
      'oferta'        => $oferta,
      'categories'    => $categories,
      'departamentos' => $departamentos,
      'ciudades'      => $ciudades,
      'modalidades'   => $modalidades,
    ]);
  }
}