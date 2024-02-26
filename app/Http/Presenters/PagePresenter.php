<?php

namespace App\Http\Presenters;

use App\Page;
use McCool\LaravelAutoPresenter\BasePresenter;

class PagePresenter extends BasePresenter
{
    public function user_name_code()
    {
        return $this->wrappedObject->name;
    }
    
    public function uriReal()
    {
         return request()->is('/') || $this->wrappedObject->uri == '/' ? url($this->wrappedObject->uri) : url('/'.$this->wrappedObject->uri);
    }
    
    public function uriWildCard()
    {
        return $this->wrappedObject->uri.'*';
    }
    
    public function prettyUri()
    {
        return '/'.ltrim($this->wrappedObject->uri, '/');
    }
    
    public function paddedTitle()
    {
        return str_repeat('&nbsp;', $this->wrappedObject->depth * 4).$this->wrappedObject->title;
    }

    public function linkToPaddedTitle($link)
    {
        $padding = str_repeat('&nbsp;', $this->wrappedObject->depth * 4);
        
        return $padding.link_to($link, $this->wrappedObject->title);
    }
}