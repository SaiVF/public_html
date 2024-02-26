<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Oferta;
use App\Child;
use App\Category;
use App\Selector;

class SelectorController extends Controller
{


  public function __construct(Oferta $ofertas, Child $children, Category $categories, Selector $selectores)

  {
    //$this->middleware('auth');
    $this->ofertas = $ofertas;
    $this->children = $children;
    $this->categories = $categories;
    $this->selectores = $selectores;
    $this->middleware('auth');

  }

  

  public function index(Request $request)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selectores = $this->selectores->orderBy('title')->get();
    //dd($selectores);
    return view('backend.selector.index', compact('selectores'));

  }

  

  public function create(Request $request, Selector $selector)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $categories = Category::whereNotNull('parent')->pluck('name', 'id');
    $selectores = config('cms.selectores');

    return view('backend.selector.form', compact('selector', 'categories', 'selectores'));

  }

  

  public function store(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selector = $this->selectores->create($request->only(
      'title',
      'type',
      'category_id'
    ));

    



    return redirect(route('selector.edit', $selector->id))->with('status', 'La entrada ha sido creada');

  }

  

  public function edit(Request $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selector = $this->selectores->findOrFail($id);
    $categories = Category::whereNotNull('parent')->pluck('name', 'id');
    $selectores = config('cms.selectores');

    return view('backend.selector.form', compact('selector', 'categories', 'selectores'));

  }



  public function update(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selector = $this->selectores->findOrFail($id);
    $selector->fill($request->only(
      'title',
      'type',
      'category_id'
    ))->save();

    return redirect(route('selector.edit', $selector->id))->with('status', 'La entrada ha sido actualizada');
  }

  

  public function confirm(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selector = $this->selectores->findOrFail($id);

    

    return view('backend.selector.confirm', compact('selector'));

  }

  

  public function destroy(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $selector = $this->selectores->findOrFail($id);

    $selector->delete();

    

    return redirect(route('selector.index'))->with('status', 'La entrada ha sido eliminada');

  }

}

