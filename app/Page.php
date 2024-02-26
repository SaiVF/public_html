<?php

namespace App;

use Baum\Node;
use DB;
use App\Http\Presenters\PagePresenter;
use McCool\LaravelAutoPresenter\HasPresenter;

class Page extends Node implements HasPresenter
{
  protected $fillable = [
  	'title',
  	'name',
    'excerpt',
  	'uri',
  	'template',
  	'hidden',
    'attr'
	];
	
	public function updateOrder($order, $orderPage)
	{
		$orderPage = $this->findOrFail($orderPage);
		
		if($order == 'before') {
			$this->moveToLeftOf($orderPage);
		} else if($order == 'after') {
			$this->moveToRightOf($orderPage);
		} else if($order == 'childOf') {
			$this->makeChildOf($orderPage);
		}
	}
  
    public function getPresenterClass()
    {
        return PagePresenter::class;
    }

  public function content() {
    return DB::table('pages_content')->where([
      ['page_id', $this->attributes['id']]
    ])->get();
  }
	
  public function pageFiles() {
    return [];
  }

  public function featuredImage() {
    return $this->theChildren()->where('attr', 1)->first();
  }

  public function theExcerpt() {
    return explode(PHP_EOL, $this->attributes['excerpt']);
  }

  public function child() {
    return $this->hasMany('App\Child', 'parent_id', 'id')->where('type', 1);
  }

  public function theImage() {
    return $this->child()->orderBy('attr', 1)->first() ?: $this->children()->first();
  }

	public function setTitleAttribute($value)
	{
		$this->attributes['title'] = trim($value);
	}

	public function setTemplateAttribute($value)
	{
		$this->attributes['template'] = $value ?: null;
	}

	public function setHiddenAttribute($value)
	{
		$this->attributes['hidden'] = !empty($value) ? 1 : 0;
	}


  public function theTags() {
    $tags = DB::table('pages_tags')->where('page_id', $this->attributes['id'])->get();
    $output = [];
    foreach($tags as $tag) {
      $output[$tag->name] = $tag->content;
    }
    $output = (object)$output;
    return $output;
  }
}
