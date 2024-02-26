<?php

namespace App\Http\Controllers\Backend;



use App\Page;

use App\Child;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;



class AjaxController extends Controller

{

	public function __construct(Page $pages, Child $children)

	{

		$this->pages = $pages;

		$this->children = $children;

	}

	

	public function ajax($model)

	{

		foreach($_POST['post'] as $key => $id) {

			DB::table($model)->where('id', $id)->update([

				'order' => $key

			]);

		}

	}

	

	public function deleteImage($model, Request $request)

	{

		$image = DB::table($model)->where('id', $request->input('id'))->first();

		DB::table($model)->where('id', $request->input('id'))->update(['image' => null]);

		unlink(public_path().'/uploads/'.$image->image);

	}

}