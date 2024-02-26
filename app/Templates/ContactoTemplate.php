<?php
namespace App\Templates;

use App\Page;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use DB;
use AutoPresenter;

class ContactoTemplate extends AbstractTemplate
{
  protected $view = 'contacto';
  
  public function __construct(Page $pages)
  {
    $this->pages = $pages;
  }
  
  public function prepare(View $view, array $parameters)
  {
    $page = $this->pages->where('uri', request()->path())->first();

    $view->with([
      'page' => $page,
    ]);
  }
}