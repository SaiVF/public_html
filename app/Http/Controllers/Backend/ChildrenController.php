<?php

namespace App\Http\Controllers\Backend;

use App\Child;
use App\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Intervention\Image\Facades\Image;

class ChildrenController extends Controller
{
  public function __construct(Child $children, Request $request, Page $pages)
  {
    $this->children = $children;
    $this->pages = $pages;
    if($request->type) $this->table = config('cms.types')[$request->type]['table'];
  }
  
  public function index(Request $request)
  {
    $children = $this->children->where(['parent_id' => $request->parent_id, 'type' => $request->type])->orderBy('category')->orderBy('order')->get();
    $parent = DB::table($this->table)
        ->select('*')
        ->where('id', $request->parent_id)
        ->first();
    return view('backend.children.index', compact('children', 'request', 'parent'));
  }
  
  public function edit($id, Request $request)
  {
    $child = $this->children->findOrFail($id);
    $parent = $child->type == 1 ? $this->pages->where('id', $child->parent_id)->first() : null;
    $categories = !empty($parent->uri) && !empty(config('cms.children.'.$parent->uri)) ? config('cms.children.'.$parent->uri) : null;
    
    return view('backend.children.form', compact('child', 'request', 'categories'));
  }

  public function update(Requests\UpdateChildRequest $request, $id)
  {
    $child = $this->children->findOrFail($id);
    
    $child->fill($request->only(
      'title',
      'excerpt',
      'content',
      'url',
      'url_text',
      'category'
    ))->save();

    if(!empty($request->file('src'))) {
      $transparent = $request->file('src')->getClientOriginalExtension() == 'png' ? true : false;
      $extension = $transparent ? $request->file('src')->getClientOriginalExtension() : 'jpg';
      $childName = slug($request->input('title')).'-'.time().'.'.$extension;
  
      $request->file('src')->move(base_path() . '/public/uploads/', $childName);
      $src = Image::make(base_path() . '/public/uploads/' . $childName);
      $background = $transparent ? null : '#ffffff';
      $img = Image::canvas($src->width(), $src->height(), $background);
      $img->insert($src)->resize(1920, null, function ($constraint) {
          $constraint->upsize();
          $constraint->aspectRatio();
      });
      $thumb = Image::make(base_path() . '/public/uploads/' . $childName)->fit(360, 360, function($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
      });
      if(!$transparent) {
        $img->encode('jpg', 80);
        $thumb->encode('jpg', 60);
      }
      $img->save(base_path() . '/public/uploads/' . $childName);
      $thumb->save(base_path() . '/public/uploads/thumbs/' . $childName);
      $child->fill([
        'src' => $childName,
      ])->save();
    }
    
    if(!empty($request->input('featured'))) {
      DB::table('children')->where([
        ['type', $child->type],
        ['parent_id', $child->parent_id]
      ])->update([
        'attr' => 0
      ]);

      $child->fill([
        'attr' => 1
      ])->save();
    } else {
      $child->fill([
        'attr' => 0
      ])->save();
    }

    return redirect(route('children.index',  ['parent_id' => $child->parent_id, 'type' => $child->type]))->with('status', 'El elemento ha sido actualizado');
  }
  
  public function confirm($id)
  {
    $child = $this->children->findOrFail($id);
    
    return view('backend.children.confirm', compact('child'));
  }
  
  public function destroy($id)
  {
    $child = $this->children->findOrFail($id);
    $child->delete();
    
    return redirect(route('children.index',  ['parent_id' => $child->parent_id, 'type' => $child->type]))->with('status', 'El elemento ha sido eliminado');
  }
  
  public function multiple(Request $request, $parent_id)
  {
    $i = 0;
    $title = slug($request->input('title'));
    foreach($request->file('files') as $file) {
      $i++;
      $child = $this->children->create($request->only('parent_id', 'type'));
      
      $transparent = $file->getClientOriginalExtension() == 'png' ? true : false;
      $extension = $transparent ? $file->getClientOriginalExtension() : 'jpg';
      $childName = slug($title).'-'.$i.'-'.time().'.'.$extension;
  
      $file->move(base_path() . '/public/uploads/', $childName);
      $src = Image::make(base_path() . '/public/uploads/' . $childName);
      $background = $transparent ? null : '#ffffff';
      $img = Image::canvas($src->width(), $src->height(), $background);
      $img->insert($src)->resize(1920, null, function ($constraint) {
          $constraint->upsize();
          $constraint->aspectRatio();
      });
      $thumb = Image::make(base_path() . '/public/uploads/' . $childName)->fit(360, 360, function($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
      });
      if(!$transparent) {
        $img->encode('jpg', 80);
        $thumb->encode('jpg', 60);
      }
      $img->save(base_path() . '/public/uploads/' . $childName);
      $thumb->save(base_path() . '/public/uploads/thumbs/' . $childName);
      $orden = DB::table('children')->select('order')->where([
        ['parent_id', $request->parent_id],
        ['type', $request->type]
      ])->orderBy('order', 'desc')->first();
      $child->fill([
        'src' => $childName,
        'order' => !is_null($orden->order) || $orden->order === 0 ? (int)$orden->order + 1 : 0
      ])->save();
    }
    return redirect(route('children.index', ['parent_id' => $child->parent_id, 'type' => $child->type]))->with('status', 'Los elementos han sido cargados');
  }

  public function upload(Request $request) {
    $transparent = $request->file('files')[0]->getClientOriginalExtension() == 'png' ? true : false;
    $extension = $transparent ? $request->file('files')[0]->getClientOriginalExtension() : 'jpg';
    $title = $request->input('title') ? slug($request->input('title')) : md5('blog'.rand());
    $childName = $title.'-'.time().'.'.$extension;
    $request->file('files')[0]->move(base_path() . '/public/uploads/', $childName);
    $src = Image::make(base_path() . '/public/uploads/' . $childName);
    $background = $transparent ? null : '#ffffff';
    $img = Image::canvas($src->width(), $src->height(), $background);
    $img->insert($src)->resize(1920, null, function ($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
    });
    $thumb = Image::make(base_path() . '/public/uploads/' . $childName)->fit(360, 360, function($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
      });
    if(!$transparent) {
      $img->encode('jpg', 80);
      $thumb->encode('jpg', 60);
    }
    $img->save(base_path() . '/public/uploads/' . $childName);
    $thumb->save(base_path() . '/public/uploads/thumbs/' . $childName);

    if($request->input('parent_id')) {
      $this->children->create([
        'type' => $request->input('type'),
        'parent_id' => $request->input('parent_id'),
        'src' => $childName,
      ])->save();
    } else {
      session()->push('children', $childName);
    }
  }

  public function attr(Request $request) {
    $child = $this->children->findOrFail($request->input('id'));
    $attr = $request->input('attr');
    $this->children->where([
      ['type', $child->type],
      ['parent_id', $child->parent_id],
      ['attr', $attr]
    ])->update([
      'attr' => null
    ]);
    $child->attr = $attr;
    $child->save();
  }
  public function remove(Request $request)
  {
    $child = $this->children->findOrFail($request->input('id'));
    $child->delete();
  }
}