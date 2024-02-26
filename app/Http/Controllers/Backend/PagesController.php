<?php

namespace App\Http\Controllers\Backend;

use App\Page;
use App\Child;
use Illuminate\Http\Request;
use Baum\MoveNotPossibleException;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PagesController extends Controller
{
  protected $pages;
  
  public function __construct(Page $pages, Child $children)
  {
    $this->pages = $pages;
    $this->children = $children;
    $this->type = 1;

    
    parent::__construct();
    //$this->middleware('auth');
  }
  
  public function index(Request $request)
  {
    //$request->user()->authorizeRoles(['Administrador');
    $pages = $this->pages->all();
    
    return view('backend.pages.index', compact('pages'));
  }
  
  public function create(Page $page)
  {
    $files = null;

    $templates = $this->getPageTemplates();
    
    $orderPages = $this->pages->where('hidden', false)->orderBy('lft', 'asc')->get();

    $pages_content = null;

    return view('backend.pages.form', compact('page', 'templates', 'orderPages', 'files', 'pages_content'));
  }
  
  public function store(Requests\StorePageRequest $request)
  {
    $page = $this->pages->create($request->only(
      'title',
      'name',
      'uri',
      'excerpt',
      'template',
      'hidden',
      'attr'
    ));

    if($request->input('order') && $request->input('order')) $this->updatePageOrder($page, $request);
    
    if(session()->has('children')) {
      foreach(session()->get('children') as $childName) {
        $this->children->create([
          'type' => $this->type,
          'parent_id' => $page->id,
          'src' => $childName
        ]);
      }
      session()->forget('children');
    }

    return redirect(route('pages.index'))->with('status', 'La página ha sido creada');
  }
  
  public function update(Requests\UpdatePageRequest $request, $id)
  {
    $page = $this->pages->findOrFail($id);
    
    $page->fill($request->only(
      'title',
      'name',
      'uri',
      'excerpt',
      'template',
      'hidden',
      'attr'
    ))->save();
    
    if(!empty($request->input('content'))) {
      foreach($request->input('content') as $key => $value) {
        DB::table('pages_content')->where('id', $key)->update([
          'title' => $value[0],
          'content' => $value[1]
        ]);
      }
    }

    if($request->input('order') && $request->input('order')) if($response = $this->updatePageOrder($page, $request)) {
      return $response;
    }

    return redirect(route('pages.edit', $page->id))->with('status', 'La página ha sido actualizada');
  }
  
  public function edit($id)
  {
    $page = $this->pages->findOrFail($id);

    if(!$page->child->isEmpty()) {
      foreach($page->child as $child) {
        $files[] = [
          'name' => $child->title ?: $child->src,
          'type' => 'image/jpeg',
          'size' => File::size(public_path().'/uploads/'.$child->src),
          'file' => url('uploads/'.$child->src),
          'data' => [
            'url' => url('uploads/'.$child->src),
            'id' => $child->id,
            'attr' => $child->attr
          ]
        ];
      }
      $files = json_encode($files);
    } else {
      $files = null;
    }

    $pages_content = DB::table('pages_content')->select('*')->where('page_id', $id)->get();

    $templates = $this->getPageTemplates();
    
    $orderPages = $this->pages->where('hidden', false)->orderBy('lft', 'asc')->get();

    return view('backend.pages.form', compact('page', 'templates', 'orderPages', 'pages_content', 'files'));
  }

  public function confirm($id)
  {
    $page = $this->pages->findOrFail($id);
    
    return view('backend.pages.confirm', compact('page'));
  }

  public function destroy($id)
  {
    $page = $this->pages->findOrFail($id);
    
    foreach($page->children as $child) {
      $child->makeRoot();
    }
    
    $page->delete();
    
    return redirect(route('pages.index'))->with('status', 'La página '. $page->name.' ha sido eliminada');
  }
  
  protected function getPageTemplates()
  {
    $templates = config('cms.templates');
    
    return ['' => ''] + array_combine(array_keys($templates), array_keys($templates));
  }
  
  protected function updatePageOrder(Page $page, Request $request)
  {
    if($request->has('order', 'orderPage')) {
      try {
        $page->updateOrder($request->input('order'), $request->input('orderPage'));
      } catch (MoveNotPossibleException $e) {
        return redirect(route('pages.edit', $page->id))->withInput()->withErrors([
          'error' => 'Imposible concretar acción'
        ]);
      }
    }
  }
}
