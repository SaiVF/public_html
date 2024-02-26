<?php

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('backend/dashboard', ['as' => 'backend.dashboard', 'uses' => 'Backend\DashboardController@index']);

// Web
Route::resource('backend/users', 'Backend\UsersController', ['except' => ['show']]);
Route::get('backend/users/solicitudes', ['as' => 'backend.users.solicitudes', 'uses' => 'Backend\UsersController@solicitudes']);
Route::get('backend/users/empresas', ['as' => 'users.empresas', 'uses' => 'Backend\UsersController@empresas']);
Route::resource('backend/pages', 'Backend\PagesController', ['except' => ['show']]);
Route::resource('backend/ofertas', 'Backend\OfertasController', ['except' => ['show']]);
Route::post('backend/ofertas/{id}/destroy', ['as' => 'backend.ofertas.destroy', 'uses' => 'Backend\OfertasController@destroy']);
Route::post('backend/ofertas/ajax/featured', ['as' => 'ajax.featured', 'uses' => 'Backend\OfertasController@featured']);
Route::get('backend/ofertas/borradores', ['as' => 'backend.ofertas.borradores', 'uses' => 'Backend\OfertasController@borradores']);
Route::get('backend/ofertas/borradores/aprobar/{id}', ['as' => 'backend.ofertas.borradores.aprobar', 'uses' => 'Backend\OfertasController@altaoferta']);
Route::get('backend/ofertas/vencidas', ['as' => 'backend.ofertas.vencidas', 'uses' => 'Backend\OfertasController@vencidas']);

/* Data */
Route::get('backend/ofertas/data', ['as' => 'backend.ofertas.data', 'uses' => 'Backend\OfertasController@ofertasData']);
Route::get('backend/vencidas/data', ['as' => 'backend.vencidas.data', 'uses' => 'Backend\OfertasController@vencidasData']);
Route::get('backend/users/data', ['as' => 'backend.users.data', 'uses' => 'Backend\UsersController@usersData']);
Route::get('backend/empresas/data', ['as' => 'backend.empresas.data', 'uses' => 'Backend\UsersController@empresasData']);
Route::get('backend/users/excel/{type}', ['as' => 'backend.users.excel', 'uses' => 'Backend\UsersController@usersExcel']);

Route::get('backend/categories/{type}', ['as' => 'backend.categories.index', 'uses' => 'Backend\CategoriesController@index']);
Route::get('backend/categories/{type}/create', ['as' => 'backend.categories.create', 'uses' => 'Backend\CategoriesController@create']);
Route::post('backend/categories/{type}/store', ['as' => 'backend.categories.store', 'uses' => 'Backend\CategoriesController@store']);
Route::get('backend/categories/{id}/edit', ['as' => 'backend.categories.edit', 'uses' => 'Backend\CategoriesController@edit']);
Route::post('backend/categories/{id}/update', ['as' => 'backend.categories.update', 'uses' => 'Backend\CategoriesController@update']);
Route::post('backend/categories/{id}/destroy', ['as' => 'backend.categories.destroy', 'uses' => 'Backend\CategoriesController@destroy']);

Route::resource('backend/children', 'Backend\ChildrenController', ['except' => ['show']]);
Route::post('backend/children/{children}/multiple', ['as' => 'backend.children.multiple', 'uses' => 'Backend\ChildrenController@multiple']);
Route::get('backend/children/{type}/{parent_id}', ['as' => 'children.index', 'uses' => 'Backend\ChildrenController@index']);
Route::resource('backend/options', 'Backend\OptionsController', ['except' => ['show']]);
Route::resource('backend/paises', 'Backend\PaisesController', ['except' => ['show']]);

Route::resource('backend/selector', 'Backend\SelectorController', ['except' => ['show']]);
Route::post('backend/selector/{id}/destroy', ['as' => 'backend.selector.destroy', 'uses' => 'Backend\SelectorController@destroy']);

Route::post('backend/children/upload', 'Backend\ChildrenController@upload');
Route::post('backend/children/remove', 'Backend\ChildrenController@remove');
Route::post('backend/children/attr', 'Backend\ChildrenController@attr');
Route::post('backend/{model}/ajax', 'Backend\AjaxController@ajax');
Route::post('backend/{model}/deleteImage', 'Backend\AjaxController@deleteImage');
Route::post('ajax/lugar', ['as' => 'ajax.lugar', 'uses' => 'MainController@lugar']);
Route::post('ajax/content', ['as' => 'ajax.content', 'uses' => 'MainController@content']);
Route::post('ajax/meinteresa', ['as' => 'ajax.meinteresa', 'uses' => 'MainController@meinteresa']);
Route::post('ajax/categoria', ['as' => 'ajax.categoria', 'uses' => 'MainController@categorias']);
Route::post('ajax/forms', ['as' => 'ajax.forms', 'uses' => 'MainController@forms']);
Route::post('ajax/temas', ['as' => 'ajax.temas', 'uses' => 'MainController@temas']);
Route::post('ajax/niveles', ['as' => 'ajax.niveles', 'uses' => 'MainController@niveles']);
Route::post('ajax/tiempo', ['as' => 'ajax.tiempo', 'uses' => 'MainController@tiempo']);
Route::post('ajax/financiamiento', ['as' => 'ajax.financiamiento', 'uses' => 'MainController@financiamiento']);
Route::post('ajax/departamento', ['as' => 'ajax.departamento', 'uses' => 'MainController@departamento']);

Route::post('filter/temas', ['as' => 'filter.temas', 'uses' => 'MainController@temaFilter']);
Route::post('filter/financiamiento', ['as' => 'filter.financiamiento', 'uses' => 'MainController@financiamientoFilter']);


Route::get('backend/users/{id}/solicitud', 'Backend\UsersController@solicitudView');
Route::post('backend/solicitud/{id}', ['as' => 'users.solicitud', 'uses' => 'Backend\UsersController@solicitud']);
Route::get('backend/solicitud/{id}/{user_id}/denegar', ['as' => 'users.solicitud.denegar', 'uses' => 'Backend\UsersController@denegar']);

Route::post('buscar/{parent?}', ['as' => 'buscar', 'uses' => 'MainController@buscar']);
Route::get('buscar', ['as' => 'buscar.parent', 'uses' => 'MainController@buscar']);
Route::post('contacto', ['as' => 'contacto', 'uses' => 'MainController@contacto']);
Route::get('oferta/{id}/{slug}', ['as' => 'post', 'uses' => 'MainController@post']);
Route::get('mi-cuenta', ['as' => 'mi-cuenta.index', 'uses' => 'MiCuentaController@index']);
Route::get('mi-cuenta/editar', ['as' => 'mi-cuenta.edit', 'uses' => 'MiCuentaController@edit']);
Route::get('mi-cuenta/ofertas', ['as' => 'mi-cuenta.ofertas', 'uses' => 'MiCuentaController@ofertas']);
Route::get('mi-cuenta/ofertas/editar/{id}', ['as' => 'mi-cuenta.ofertas.edit', 'uses' => 'MiCuentaController@editOferta']);
Route::post('mi-cuenta/ofertas/update/{id}', ['as' => 'mi-cuenta.ofertas.editar', 'uses' => 'MiCuentaController@updateOferta']);
Route::post('mi-cuenta/ofertas/delete/{id}', ['as' => 'mi-cuenta.ofertas.delete', 'uses' => 'MiCuentaController@deleteOferta']);


Route::post('cuenta/editar', ['as' => 'preferencias', 'uses' => 'MiCuentaController@preferencias']);
Route::post('solicitud/empresa', ['as' => 'empresa', 'uses' => 'MiCuentaController@empresa']);
Route::post('oferta/postear', ['as' => 'oferta.postear', 'uses' => 'MainController@postear']);
Route::get('oferta/editar/{id}', ['as' => 'oferta.editar', 'uses' => 'MainController@editar']);
Route::post('oferta/update/{id}', ['as' => 'oferta.update', 'uses' => 'MiCuentaController@updateOferta']);
Route::get('mi-cuenta/solicitud/colaborador', ['as' => 'micuenta.solicitud', 'uses' => 'MiCuentaController@verify']);

Route::get('hallate/webservice/snpp', ['as' => 'hallate.webservice.snpp', 'uses' => 'WebserviceController@snppRun']);
Route::get('hallate/webservice/stp', ['as' => 'hallate.webservice.stp', 'uses' => 'WebserviceController@stpRun']);
Route::get('hallate/webservice/sfp', ['as' => 'hallate.webservice.sfp', 'uses' => 'WebserviceController@sfpRun']);
Route::get('hallate/webservice/pivot', ['as' => 'hallate.webservice.pivot', 'uses' => 'WebserviceController@pivotRun']);

Route::post('ofertas/destacados', ['as' => 'oferta.destacados', 'uses' => 'MainController@destacados']);
Route::post('ofertas/lo-mas-nuevo', ['as' => 'oferta.news', 'uses' => 'MainController@news']);
Route::post('ofertas/por-vencer', ['as' => 'oferta.vencer', 'uses' => 'MainController@vencer']);


//Route::post('oferta/postear', 'MainController@postear');
Route::get('chat', function(){
	return redirect('livechat/php/app.php?login');
});



Route::get('snpptemp', function(){
	return abort(401);
	function utf($string = NULL){
		if ($string) {
			return mb_convert_encoding($string, 'ISO-8859-1','utf-8');
		}else {
			return '';
		}
	};


	$body = '{
			"codServicio": "04213",
			"tipoTrx": "05",
			"usuario": "SJ_SISGAF",
			"password": "g3a9b8#(pzq)"
			}';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.programacionsnpp.com/sisgaf2/webserv/sjuventud/consultas/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	$result = curl_exec($ch);
	$data = json_decode($result, true);
	$ar = array($data);
	/*$collection = collect($ar[0]);
	$filtered = $collection->where('fecha_de_inicio', '>', '2018-06-05');
	$filtered->all();
    return $filtered->count();*/
    
	foreach ($ar[0] as $key => $value) {
		

		$nombre = utf($value['nombre']);
		$institucion_oferente = utf($value['institucion_oferente']);
		$descripcion = utf($value['descripcion']);
		$requisitos = utf($value['requisitos']);
		$observaciones = utf($value['observaciones']);
		DB::table('ofertas')->insert(
		    ['title' => $nombre, 'source' => 'SNPP', 'source_id' => $value['cod_pds'], 'fecha_limite' => $value['fecha_de_inicio'], 'lugar' => 'En el país', 'lugar_aplicar' => $institucion_oferente, 'descripcion' => $descripcion, 'requisito' => $requisitos, 'obs' => $observaciones, 'url' => $value['accede_aca'], 'precio' => $value['costo'], 'pais_id' => 179, 'state' => 1, 'deleted' => 0, 'borrador' => 1]
		);

	}

	return 'success snpp';
	

});


Route::get('snpp_category', function(){
	return abort(401);
	$ofertas = \App\Oferta::where('source', 'SNPP')->where('state', 1)->where('deleted', 0)->get();
	
	
	foreach ($ofertas as $oferta) {
		
		DB::table('categories_relationships')->insert(
		    ['category_id' => 3, 'type' => 3, 'parent_id' => $oferta->id]
		);
	}
	return 'success';


	//return $ofertas;
});

Route::get('stp', function(){
	return abort(401);
	$hoy = \Carbon\Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    //return $hoy;

	function utf($string = NULL){
		if ($string) {
			return mb_convert_encoding($string, 'ISO-8859-1','utf-8');
		}else {
			return '';
		}
	};


	$ar = json_decode(file_get_contents('http://webmail.stp.gov.py/intranet/arres/index.php/becas'));
	
	$collection = collect($ar);
	$filtered = $collection->where('fechalimite', '>', '2018-06-05');
	$filtered->all();
		
	foreach ($filtered as $oferta) {
		$titulo  = utf($oferta->titulo);
		$institucion_oferente = utf($oferta->oferente);
		$descripcion = utf($oferta->descripcion);
		$requisitos = utf($oferta->requisitos);
		$beneficios = utf($oferta->financiamiento);

		DB::table('ofertas')->insert(
		    ['title' => $titulo, 'nivel' => $oferta->nivel, 'source' => 'STP', 'source_id' => $oferta->id, 'fecha_limite' => $oferta->fechalimite, 'lugar' => 'En el país', 'lugar_aplicar' => $institucion_oferente, 'beneficios' => $beneficios, 'descripcion' => $descripcion, 'requisito' => $requisitos, 'obs' => '', 'url' => '', 'precio' => $oferta->financiamiento, 'pais_id' => 179, 'state' => 1, 'deleted' => 0, 'borrador' => 1]
		);
		
	}
	
	return 'success';


});
Route::get('stp_category', function(){
	return abort(401);
	$ofertas = \App\Oferta::where('source', 'STP')->where('state', 1)->where('deleted', 0)->get();
	
	//return $ofertas->count();
	foreach ($ofertas as $oferta) {
		
		DB::table('categories_relationships')->insert(
		    ['category_id' => 9, 'type' => 3, 'parent_id' => $oferta->id]
		);
	}


	return 'success stp category';
});