<?php

namespace App\Http\Controllers\Backend;

use App\Comercio;
use App\Child;
use App\Category;
use App\Http\Requests;

class ComerciosController extends Controller
{

	public function __construct(Comercio $comercios, Child $children, Category $categories)
	{
    $this->comercios = $comercios;
    $this->children = $children;
		$this->categories = $categories;
	}
	
  public function index()
	{
		$comercios = $this->comercios->orderBy('created_at', 'desc')->get();
		
		return view('backend.comercios.index', compact('comercios'));
	}
	
	public function create(Comercio $comercio)
	{
    $files = null;
    $categories = $this->categories->whereNotNull('parent')->orderBy('name')->pluck('name', 'id');

		return view('backend.comercios.form', compact('comercio', 'files', 'categories'));
	}
	
	public function store(Requests\StoreComercioRequest $request)
	{
		$comercio = $this->comercios->create($request->only(
      'nombre',
      'content',
      'direccion',
      'location',
      'website',
      'telefono',
      'email',
      'category',
      'facebook',
      'instagram',
      'twitter'
		));
				
    $this->children->whereNull('type')->whereNull('parent_id')->where('_token', $request->input('_token'))->update([
      'type' => 3,
      'parent_id' => $comercio->id
    ]);

    session()->regenerateToken();

		return redirect(route('comercios.edit', $comercio->id))->with('status', 'La entrada ha sido creada');
	}
	
	public function edit($id)
	{
		$comercio = $this->comercios->findOrFail($id);
    if(!$comercio->children()->isEmpty()) {
      foreach($comercio->children() as $child) {
        $files[] = [
          'name' => $child->title ?: $child->src,
          'type' => 'image/jpeg',
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
    $categories = $this->categories->whereNotNull('parent')->orderBy('name')->pluck('name', 'id');
		
		return view('backend.comercios.form', compact('comercio', 'files', 'categories'));
	}
	public function update(Requests\UpdateComercioRequest $request, $id)
	{
		$comercio = $this->comercios->findOrFail($id);
		
		$comercio->fill($request->only(
      'nombre',
      'content',
      'direccion',
      'location',
      'website',
      'telefono',
      'email',
      'category',
      'facebook',
      'instagram',
      'twitter'
		))->save();
		
    session()->regenerateToken();

		return redirect(route('comercios.edit', $comercio->id))->with('status', 'La entrada ha sido actualizada');
	}
	
	public function confirm($id)
	{
		$comercio = $this->comercios->findOrFail($id);
		
		return view('backend.comercios.confirm', compact('comercio'));
	}
	
	public function destroy($id)
	{
		$comercio = $this->comercios->findOrFail($id);
		$comercio->delete();
		
		return redirect(route('comercios.index'))->with('status', 'La entrada ha sido eliminada');
	}
}
