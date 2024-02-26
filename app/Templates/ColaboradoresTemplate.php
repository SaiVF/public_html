<?php
namespace App\Templates;

use App\Page;
use App\Category;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;
use App\Child;

class ColaboradoresTemplate extends AbstractTemplate
{
  protected $view = 'colaboradores';
  
  public function __construct(Page $pages, Category $categories)
  {
    $this->pages = $pages;
    $this->categories = $categories;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();
    $categories = $this->categories->whereNull('parent')->orderBy('order')->get();
    $logos = Child::where('attr', '!=', 1)->where('parent_id', $page->id)->where('type', 1)->orderBy('order', 'DES')->get();


    $view->with([
      'page'        =>   $page,
      'categories'  =>   $categories,
      'logos'    =>   $logos
    ]);
  }
}