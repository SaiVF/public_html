<?php



namespace App\Composers;



use App\Page;

use Illuminate\View\View;



class InjectPages

{

	protected $pages;

	

	public function __construct(Page $pages)

	{

		$this->pages = $pages;

	}

	

	public function compose(View $view)

	{

		// $pages = $this->pages->where('hidden', false)->get()->toHierarchy();

		$pages = $this->pages->get()->toHierarchy();

		$view->with('pages', $pages);

	}

}

