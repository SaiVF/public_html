<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Child;
use App\Category;
use App\Http\Requests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use AutoPresenter;

class ProductosController extends Controller
{

  public function __construct(Producto $productos, Child $children, Category $categories)
  {
    $this->productos = $productos;
    $this->children = $children;
    $this->categories = $categories;
  }

  public function index()
  {
    $productos = $this->productos->orderBy('order')->get();

    return view('backend.productos.index', compact('productos'));
  }

  public function create(Producto $producto)
  {
    $files = null;
    $parents = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();
    $categories = $this->categories->whereNotIn('id', $this->categories->whereNotNull('parent')->pluck('parent'))->where('type', 3)->orderBy('name')->pluck('name', 'id');
    $marcas = $this->categories->where('type', 100)->orderBy('order')->pluck('name', 'id');

    return view('backend.productos.form', compact('producto', 'files', 'categories', 'marcas'));
  }

  public function store(Requests\StoreProductoRequest $request)
  {
    $producto = $this->productos->create($request->only(
      'title',
      'code',
      'marca',
      'excerpt',
      'content',
      'price',
      'new_price'
    ));

    $producto->fill([
      'featured' => !empty($request->input('featured')) ? 1 : 0,
      'out_of_stock' => !empty($request->input('out_of_stock')) ? 1 : 0
    ])->save();

    DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $producto->id]
    ])->delete();

    foreach ($request->input('category') as $category_id)
    {
      DB::table('categories_relationships')->insert([
        'category_id' => $category_id,
        'type' => 3,
        'parent_id' => $producto->id
      ]);
    }

    if (session()->has('children'))
    {
      foreach (session()->get('children') as $childName)
      {
        $this->children->create([
          'type' => 3,
          'parent_id' => $producto->id,
          'src' => $childName
        ]);
      }
      session()->forget('children');
    }

    return redirect(route('productos.edit', $producto->id))->with('status', 'La entrada ha sido creada');
  }

  public function edit($id)
  {
    $producto = $this->productos->findOrFail($id);
    if (!$producto->theChildren()->isEmpty())
    {
      foreach ($producto->theChildren() as $child)
      {
        $files[] = [
          'name' => $child->title ?: $child->src,
          'type' => 'image/jpeg',
          'size' => File::size(public_path() . '/uploads/' . $child->src),
          'file' => url('uploads/' . $child->src),
          'data' => [
            'url' => url('uploads/' . $child->src),
            'id' => $child->id,
            'attr' => $child->attr
          ]
        ];
      }
      $files = json_encode($files);
    }
    else
    {
      $files = null;
    }
    $parents = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();

    $categories = $this->categories->whereNotIn('id', $this->categories->whereNotNull('parent')->pluck('parent'))->where('type', 3)->orderBy('name')->pluck('name', 'id');
    $selected_categories = DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $producto->id]
    ])->pluck('category_id');
    $marcas = $this->categories->where('type', 100)->orderBy('order')->pluck('name', 'id');

    return view('backend.productos.form', compact('producto', 'files', 'categories', 'marcas', 'selected_categories'));
  }

  public function update(Requests\UpdateProductoRequest $request, $id)
  {
    $producto = $this->productos->findOrFail($id);

    $producto->fill($request->only(
      'title',
      'code',
      'marca',
      'excerpt',
      'content',
      'price',
      'new_price'
    ))->save();

    $producto->fill([
      'featured' => !empty($request->input('featured')) ? 1 : 0,
      'out_of_stock' => !empty($request->input('out_of_stock')) ? 1 : 0
    ])->save();

    DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $producto->id]
    ])->delete();
    foreach ($request->input('category') as $category_id)
    {
      DB::table('categories_relationships')->insert([
        'category_id' => $category_id,
        'type' => 3,
        'parent_id' => $producto->id
      ]);
    }

    return redirect(route('productos.edit', $producto->id))->with('status', 'La entrada ha sido actualizada');
  }

  public function confirm($id)
  {
    $producto = $this->productos->findOrFail($id);

    return view('backend.productos.confirm', compact('producto'));
  }

  public function destroy($id)
  {
    $producto = $this->productos->findOrFail($id);
    $producto->delete();

    return redirect(route('productos.index'))->with('status', 'La entrada ha sido eliminada');
  }
}
