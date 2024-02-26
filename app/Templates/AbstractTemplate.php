<?php
namespace App\Templates;
use Illuminate\View\View;

abstract class AbstractTemplate
{
	protected $view;
	
	abstract function prepare(View $view, array $parameters);
	
	public function getView()
	{
		return $this->view;
	}
}
