<?php

namespace App\Composers;

use App\Page;
use App\Category;
use Illuminate\View\View;

class GlobalContent
{
  protected $pages;
  
  public function __construct(Page $pages, Category $categories)
  {
    $this->pages = $pages;
    $this->categories = $categories;
  }
  
  public function compose(View $view)
  {
    $productos_categories = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();
    
    $view->with('productos_categories', $productos_categories);
  }
}
