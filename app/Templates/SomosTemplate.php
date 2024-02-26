<?php
namespace App\Templates;

use App\Page;
use App\Category;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;

class SomosTemplate extends AbstractTemplate
{
  protected $view = 'somos';
  
  public function __construct(Page $pages, Category $categories)
  {
    $this->pages = $pages;
    $this->categories = $categories;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();
    $categories = $this->categories->whereNull('parent')->orderBy('order')->get();

    $view->with([
      'page' => $page,
      'categories' => $categories,
    ]);
  }
}