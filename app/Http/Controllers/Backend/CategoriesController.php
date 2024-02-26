<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Requests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
	protected $categories;
	
	public function __construct(Category $categories)
	{
		$this->categories = $categories;
    $this->types = config('cms.types');
	}
	
	public function index($id)
	{
    $type = (object)$this->types[$id];
    $categories = $this->categories->where('type', $type->id)->orderBy('parent')->orderBy('order')->get();

		return view('backend.categories.index', compact('categories', 'type'));
	}
	
	public function create($id, Category $category)
	{
    $type = (object)$this->types[$id];
    $parents = $this->categories->whereNull('parent')->where('type', $type->id)->orderBy('order')->pluck('name', 'id');

		return view('backend.categories.form', compact('category', 'type', 'parents'));
	}
	
	public function store($id, Requests\StoreCategoryRequest $request)
	{
		$category = $this->categories->create($request->only(
	  	'name',
	  	'excerpt',
	  	'content',
	  	'parent',
	  	'color',
	  	'color_principal',
	  	'svg',
	  	'related_words'
		));
		
    $category->fill(['type' => $id])->save();

    $order = DB::table('categories')->select('order')->orderBy('order')->value('order');

		$category->fill(['order' => !is_null($order) || $order === 0 ? (int)$order + 1 : 0])->save();

		if(!empty($request->file('image'))) {
			$file = $request->file('image');

    	$imageName = slug($category->title).'-'.time().'.png';

	    $filename = base_path().'/public/uploads/'.$imageName;

	    $transparent = true;
	    $file->move(base_path().'/public/uploads/', $imageName);
			$src = Image::make(base_path() . '/public/uploads/' . $imageName);
			$background = $transparent ? null : '#ffffff';
			$img = Image::canvas($src->width(), $src->height(), $background);
			$img->insert($src)->resize(1920, null, function ($constraint) {
			    $constraint->upsize();
			    $constraint->aspectRatio();
			});

			$thumb = Image::make(base_path() . '/public/uploads/' . $imageName)->fit(360, 360, function ($constraint) {
			    $constraint->upsize();
			    $constraint->aspectRatio();
			});

			$img->save(base_path() . '/public/uploads/' . $imageName);
			$thumb->save(base_path() . '/public/uploads/thumbs/' . $imageName);

			$category->fill([
				'image' => $imageName,
			])->save();

		}

		return redirect(route('backend.categories.index', $id))->with('status', 'La categoría ha sido creada');
	}
	
	public function edit($id)
	{
		$category = $this->categories->findOrFail($id);
	  	$type = (object)$this->types[$category->type];
    	$parents = $this->categories->whereNull('parent')->where('type', $type->id)->orderBy('order')->pluck('name', 'id');

		return view('backend.categories.form', compact('category', 'parents', 'type'));
	}

	public function update($id, Requests\StoreCategoryRequest $request)
	{
		$category = $this->categories->findOrFail($id);
		
		$category->fill($request->only(
	  	'name',
	  	'excerpt',
	  	'content',
	  	'parent',
	  	'color',
	  	'color_principal',
	  	'svg',
	  	'related_words'
		))->save();
		
		$order = DB::table('categories')->select('order')->orderBy('order')->value('order');

		$category->fill(['order' => !is_null($order) || $order === 0 ? (int)$order + 1 : 0])->save();

		if(!empty($request->file('image'))) {
			$file = $request->file('image');

    	$imageName = slug($category->title).'-'.time().'.png';

	    $filename = base_path().'/public/uploads/'.$imageName;

	    $transparent = true;
	    $file->move(base_path().'/public/uploads/', $imageName);
			$src = Image::make(base_path() . '/public/uploads/' . $imageName);
			$background = $transparent ? null : '#ffffff';
			$img = Image::canvas($src->width(), $src->height(), $background);
			$img->insert($src)->resize(1920, null, function ($constraint) {
			    $constraint->upsize();
			    $constraint->aspectRatio();
			});

			$thumb = Image::make(base_path() . '/public/uploads/' . $imageName)->resize(360, null, function ($constraint) {
			    $constraint->upsize();
			    $constraint->aspectRatio();
			});

			$img->save(base_path() . '/public/uploads/' . $imageName);
			$thumb->save(base_path() . '/public/uploads/thumbs/' . $imageName);

			$category->fill([
				'image' => $imageName,
			])->save();
		}
		
		return redirect(route('backend.categories.edit', $category->id))->with('status', 'La categoría ha sido actualizada');
	}
	
	public function confirm($id)
	{
		$category = $this->categories->findOrFail($id);
		
		return view('backend.categories.confirm', compact('category'));
	}
	
	public function destroy($id)
	{
		$category = $this->categories->findOrFail($id);
    $type = $category->type;
    $category->delete();
    
		return redirect(route('backend.categories.index', $type))->with('status', 'La categoría ha sido eliminada');
	}
}
