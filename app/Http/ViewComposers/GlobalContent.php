<?php

namespace App\Http\ViewComposers;

use App\Page;
use App\Post;
use App\Category;
use Illuminate\View\View;
use DB;
use Date;

class GlobalContent
{
  public function __construct(Page $pages, Post $posts, Category $categories)
  {
    $this->posts = $posts;
    $this->pages = $pages;
    $this->categories = $categories;
  }

  public function compose(View $view)
  {
    $productos_categories = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();
    
    $view->with('productos_categories', $productos_categories);
  }
}
