<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\DB;
use App\Post;
use App\Child;
use App\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{

  public function __construct(Post $posts, Child $children, Category $categories)
  {
    $this->posts = $posts;
    $this->children = $children;
    $this->categories = $categories;
  }
  
  public function index()
  {
    $posts = $this->posts->orderBy('published_at', 'desc')->get();
    
    return view('backend.blog.index', compact('posts'));
  }
  
  public function create(Post $post)
  {
    $files = null;
    $parents = $this->categories->where('type', 2)->whereNull('parent')->orderBy('order')->get();
    /*
    $categories = [];
    foreach($parents as $parent) {
      $categories[$parent->name] = $this->categories->where('parent', $parent->id)->orderBy('order')->pluck('name', 'id')->toArray();
    }
    */
    $categories = $this->categories->whereNull('parent')->where('type', 2)->orderBy('order')->pluck('name', 'id');
    $authors = $this->categories->where('type', 5)->orderBy('order')->pluck('name', 'id');

    return view('backend.blog.form', compact('post', 'files', 'categories', 'authors'));
  }
  
  public function store(Requests\StorePostRequest $request)
  {
    $post = $this->posts->create($request->only(
      'title',
      'excerpt',
      'content',
      'published_at',
      'featured',
      'author'
    ));
    
    if(!empty($request->input('category'))) {
      DB::table('categories_relationships')->where([
        ['type', 2],
        ['parent_id', $post->id]
      ])->delete();
      foreach($request->input('category') as $category_id) {
        DB::table('categories_relationships')->insert([
          'category_id' => $category_id,
          'type' => 2,
          'parent_id' => $post->id
        ]);
      }
    }

    if(session()->has('children')) {
      foreach(session()->get('children') as $childName) {
        $this->children->create([
          'type' => 2,
          'parent_id' => $post->id,
          'src' => $childName
        ]);
      }
      session()->forget('children');
    }

    return redirect(route('blog.edit', $post->id))->with('status', 'La entrada ha sido creada');
  }
  
  public function edit($id)
  {
    $post = $this->posts->findOrFail($id);
    if(!$post->theChildren()->isEmpty()) {
      foreach($post->theChildren() as $child) {
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
    $parents = $this->categories->where('type', 2)->whereNull('parent')->orderBy('order')->get();
    /*
    $categories = [];
    foreach($parents as $parent) {
      $categories[$parent->name] = $this->categories->where('parent', $parent->id)->orderBy('order')->pluck('name', 'id')->toArray();
    }
    */
    $categories = $this->categories->whereNull('parent')->where('type', 2)->orderBy('order')->pluck('name', 'id');
    $selected_categories = DB::table('categories_relationships')->where([
      ['type', 2],
      ['parent_id', $post->id]
    ])->pluck('category_id');
    $authors = $this->categories->where('type', 5)->orderBy('order')->pluck('name', 'id');

    return view('backend.blog.form', compact('post', 'files', 'categories', 'selected_categories', 'authors'));
  }

  public function update(Requests\UpdatePostRequest $request, $id)
  {
    $post = $this->posts->findOrFail($id);
    
    $post->fill($request->only(
      'title',
      'excerpt',
      'content',
      'published_at',
      'featured',
      'author'
    ))->save();
    
    if(!empty($request->input('category'))) {
      DB::table('categories_relationships')->where([
        ['type', 2],
        ['parent_id', $post->id]
      ])->delete();
      foreach($request->input('category') as $category_id) {
        DB::table('categories_relationships')->insert([
          'category_id' => $category_id,
          'type' => 2,
          'parent_id' => $post->id
        ]);
      }
    }

    return redirect(route('blog.edit', $post->id))->with('status', 'La entrada ha sido actualizada');
  }
  
  public function confirm($id)
  {
    $post = $this->posts->findOrFail($id);
    
    return view('backend.blog.confirm', compact('post'));
  }
  
  public function destroy($id)
  {
    $post = $this->posts->findOrFail($id);
    $post->delete();
    
    return redirect(route('blog.index'))->with('status', 'La entrada ha sido eliminada');
  }
}
