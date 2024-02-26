<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use App\Oferta;
use App\Solicitud;
use App\Favorite;
use App\Category;
use App\Pais;
use DB;
use Mail;

class MiCuentaController extends Controller
{
  public function __construct(User $users)
  {
    $this->users = $users;
  }
  
  public function index()
  {
    if(!\Auth::user()) abort(401);

    $ofertas = Oferta::where('state', 1)->where('borrador', 1)->orderBy('created_at', 'DESC')->limit(6)->get();
    $favorites = Favorite::where('user_id', \Auth::user()->id)->get();

    return view('templates.mi-cuenta.index', compact('ofertas', 'favorites'));
  }

  public function edit()
  {
    if(!\Auth::user()){
      return redirect('login');
    }
    $departamentos = DB::table('departamentos')->pluck('nombre', 'id');
    $sexo = config('cms.sexo');

    return view('templates.mi-cuenta.edit', compact('departamentos', 'sexo'));
  }
  
  public function paquetes()
  {
    if(!\Auth::user()) abort(401);
    $packages = $this->packages->where('user_id', \Auth::user()->id)->get();
    return view('templates.mi-cuenta.paquetes', compact('packages'));
  }

  public function ofertas()
  {
    //return abort(404);
    if(!\Auth::user()) abort(401);
    if(!\Auth::user()->isEmpresa()) abort(401);
    $ofertas = Oferta::where('state', 1)->where('deleted', 0)->where('owner', \Auth::user()->id)->paginate(15);
    $ocultas = Oferta::where('state', 0)->where('deleted', 0)->where('owner', \Auth::user()->id)->paginate(15);
    return view('templates.mi-cuenta.ofertas', compact('ofertas', 'ocultas'));
  }
  public function editOferta($id)
  {
    $oferta = Oferta::find($id);
    if (!$oferta) {
      return abort(404);
    }
    $ejes = Category::whereNull('parent')->orderBy('order', 'ASC')->pluck('name', 'id');
    $categories = Category::where('parent', $oferta->theCategory()->parent)->orderBy('order', 'ASC')->pluck('name', 'id');
    $paises = Pais::pluck('nombre', 'id');
    

    $selected_categories = DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $oferta->id]
    ])->pluck('category_id')->first();
    
    $selected_eje = DB::table('categories')->where([
      ['type', 3],
      ['id', $selected_categories]
    ])->pluck('parent');
    $selected_pais = Pais::where('id', $oferta->pais_id)->pluck('id');
    $niveles = DB::table('select')->where('type', 'niveles')->where('category_id', $selected_categories)->pluck('title', 'title');
    $niveles->prepend('No aplica', 'No aplica');
    $temas = DB::table('select')->where('type', 'temas')->where('category_id', $selected_categories)->pluck('title', 'title');
    $temas->prepend('No aplica', 'No aplica');
    $tiempo = DB::table('select')->where('type', 'tiempo')->where('category_id', $selected_categories)->pluck('title', 'title');
    $tiempo->prepend('No aplica', 'No aplica');
    $financiamiento = DB::table('select')->where('type', 'financiamiento')->where('category_id', $selected_categories)->pluck('title', 'title');
    $financiamiento->prepend('No aplica', 'No aplica');
    $tags = DB::table('taggables')->where('taggable_id', $oferta->id)->pluck('tag_id');
    $selected_tags = DB::table('tags')->whereIn('id', $tags)->pluck('name')->implode(',');
    $departamentos = DB::table('departamentos')->pluck('nombre', 'nombre');
    $modalidades = config('cms.modalidad');
    $ciudades = DB::table('ciudades')->pluck('nombre', 'nombre');
    //$selected_tags = implode(', ',$selected_tags);
    //return $selected_tags;


    return view('templates.postea')->with([
      'oferta'              => $oferta,
      'ejes'                => $ejes,
      'categories'          => $categories,
      'paises'              => $paises,
      'selected_categories' => $selected_categories,
      'selected_eje'        => $selected_eje,
      'selected_pais'       => $selected_pais,
      'niveles'             => $niveles,
      'temas'               => $temas,
      'tiempo'              => $tiempo,
      'financiamiento'      => $financiamiento,
      'tags'                => $tags,
      'selected_tags'       => $selected_tags,
      'departamentos'       => $departamentos,
      'modalidades'         => $modalidades,
      'ciudades'            => $ciudades
    ]);
  }
  public function updateOferta(Request $request, $id)
  {
      
    $ip = getUserIP();
    $recaptcha = $request->get('g-recaptcha-response');
    if ($recaptcha) {   
	    $post_data = http_build_query(
		    array(
		        'secret' => '6LfMWlgUAAAAACIaxUWj2a0PwPd75QoABOs_uCeu',
		        'response' => $recaptcha,
		        'remoteip' => $ip
		    )
		);
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $post_data
		    )
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);
		if (!$result->success) {
			session()->flash('validator', 'Ocurrió un erro con la confirmación del Recaptcha, por favor intenta de nuevo.');
			$request->flash();
			return redirect(route('mi-cuenta.ofertas.edit', ['id' => $id]));
		}
	}elseif(!$recaptcha){
    
    session()->flash('validator', 'Debes confirmar el Recaptcha.');
      $request->flash();
    return redirect(route('mi-cuenta.ofertas.edit', ['id' => $id]));
  }

    $rules = [
        'title' => 'required|max:255',
        'category' => ['required'],
        'contacto_con' => ['required'],
        'nivel' => ['required'],
        'tema' => ['required'],
        'tiempo' => ['required'],
        'precio' => ['required'],
        'descripcion' => ['required'],
        'pais_id' => ['required'],
        'departamento' => ['required'],
        'ciudad' => ['required'],
        'vacancias_disponibles' => 'required|numeric'
        //'g-recaptcha-response' => ['required']
    ];
    $messages = [
      'title.required' => 'Debes completar el título de la oportunidad.',
      'title.max' => 'El título de la oferta no puede contener mas de 250 caracteres.',
      'category.required' => 'Debes elegir una categoría para la oportunidad.',
      'contacto_con.required' => 'Debes completar un contacto.',
      'nivel.required' => 'Debes elegir un nivel para la oportunidad.',
      'tema.required' => 'Debes elegir un tema para la oportunidad.',
      'tiempo.required' => 'Debes elegir un tiempo para la oportunidad.',
      'precio.required' => 'Debes elegir un tipo de financiamiento para oportunidad.',
      'descripcion.required' => 'Debes redactar una descripción para la oportunidad.',
      'pais_id.required' => 'Debes elegir el País donde se desarrolla la oportunidad.',
      'departamento.required' => 'Debes elegir el Departamento, Estado o Provincia donde se desarrolla la oportunidad.',
      'ciudad.required' => 'Debes elegir la ciudad donde se desarrolla la oportunidad.',
      //'g-recaptcha-response.required' => 'Debes confirmar el Recaptcha.'

    ];

    $this->validate($request, $rules, $messages);
    


    if (\Auth::user()) {
      $user = \Auth::user()->id;
      $type = 3;
      $anonimo = 0;

      if ($request->anonimo) {
        $anonimo = 1;
      }
      if ($request->nivel) {
        $nivel = $request->nivel;
      }elseif($request->nivel_alt) {
        $nivel = $request->nivel_alt;
      }else{
        $nivel = NULL;
      }

      if ($request->tema) {
        $tema = $request->tema;
      }elseif($request->tema_alt) {
        $tema = $request->tema_alt;
      }else{
        $tema = NULL;
      }

      if ($request->financiamiento) {
        $financiamiento = $request->financiamiento;
      }elseif($request->financiamiento_alt) {
        $financiamiento = $request->financiamiento_alt;
      }else{
        $financiamiento = NULL;
      }

      if ($request->tiempo) {
        $tiempo = $request->tiempo;
      }elseif($request->tiempo_alt) {
        $tiempo = $request->tiempo_alt;
      }else{
        $tiempo = NULL;
      }

      $oferta = Oferta::find($id);
      if (!$oferta) {
        return abort(404);
      }
      $oferta->title                    = $request->title;
      $oferta->fecha_inicio             = $request->fecha_inicio ? $request->fecha_inicio : NULL;
      $oferta->fecha_limite             = $request->fecha_limite ? $request->fecha_limite : NULL;
      $oferta->vacancias_disponibles    = $request->vacancias_disponibles ? $request->vacancias_disponibles : NULL;
      $oferta->descripcion              = $request->descripcion ? $request->descripcion : NULL;
      $oferta->beneficios               = $request->beneficios ? $request->beneficios : NULL;
      $oferta->nivel                    = $nivel;
      $oferta->tema                     = $tema;
      $oferta->tiempo                   = $tiempo;
      $oferta->precio                   = $financiamiento;
      $oferta->inicio_aplicacion        = $request->inicio_aplicacion ? $request->inicio_aplicacion : NULL;
      $oferta->cierre_aplicacion        = $request->cierre_aplicacion ? $request->cierre_aplicacion : NULL;
      $oferta->proceso_aplicacion       = $request->proceso_aplicacion ? $request->proceso_aplicacion : NULL;
      $oferta->requisito                = $request->requisito ? $request->requisito : NULL;
      $oferta->url                      = $request->url ? $request->url : NULL;
      $oferta->uri_aplicacion           = $request->uri_aplicacion ? $request->uri_aplicacion : NULL;
      $oferta->contacto_con             = $request->contacto_con ? $request->contacto_con : NULL;
      $oferta->pais_id                  = $request->pais_id ? $request->pais_id : NULL;
      $oferta->ciudad                   = $request->ciudad ? $request->ciudad : NULL;
      $oferta->departamento             = $request->departamento ? $request->departamento : NULL;
      $oferta->lugar                    = $request->lugar ? $request->lugar : NULL;
      $oferta->owner                    = $user;
      $oferta->anonimo                  = $anonimo;
      $oferta->modalidad                = $request->modalidad ? $request->modalidad : NULL;
      
      $oferta->state                    = $request->state;
        
      $oferta->save();

      DB::table('categories_relationships')->where([
        ['type', 3],
        ['parent_id', $oferta->id]
      ])->delete();
      

      DB::table('categories_relationships')->insert([
        'category_id' => $request->category,
        'type' => 3,
        'parent_id' => $oferta->id
      ]);

      DB::table('taggables')->where('taggable_id', $oferta->id)->delete();

      $array = explode(",", $request->get('tags')[0]);
      if ($array) {
        foreach ($array as $tag) {
          $exist = DB::table('tags')->where(['name' => $tag])->first();
          if ($exist) {
            DB::table('taggables')->insert(['tag_id' => $exist->id, 'taggable_id' => $oferta->id, 'taggable_type' => 'ofertas']);
          }else {
            $tag = DB::table('tags')->insertGetId(['name' => $tag]);
            echo $tag;
            DB::table('taggables')->insert(['tag_id' => $tag, 'taggable_id' => $oferta->id, 'taggable_type' => 'ofertas']);
          }
        }
      }

      /*
      DB::table('categories_relationships')->where([
        ['type', 3],
        ['parent_id', $oferta->id]
      ])->delete();

      foreach($request->input('category') as $category_id) {
        DB::table('categories_relationships')->insert([
          'category_id' => $category_id,
          'type' => 3,
          'parent_id' => $oferta->id
        ]);
      }
      */

      session()->flash('success', '¡Tu oferta ha sido actualizada!');
      return redirect()->back();
    }
    else {
      abort(500);
    }

    
  }
  
  public function preferencias(Request $request)
  {

  	//return $request->input('password');
    if(!\Auth::user()) abort(401);
    if(!empty($request->input())) {
      $user = $this->users->findOrFail(\Auth::user()->id);

      if (!$request->terminos) {
        session()->flash('success', 'Debes aceptar los términos y condiciones');
        return redirect('mi-cuenta/editar');
      }else{
        $request->validate([
          'name' => 'required',
          'email' => 'email|unique:users,email,'.\Auth::user()->id,
          'ci' => 'required',
          'telefono'=> 'required',
          'direccion' => 'required'/*,
          'empresa' => 'required',
          'trato_autoridad' => ['required'],
          'nombre_autoridad' => ['required'],
          'trato_nexo' => ['required'],
          'nombre_nexo' => ['required'],
          'telefono_nexo' => ['required'],
          'correo_nexo' => ['required'],
          'url' => ['required'],
          'direccion_nexo' => ['required'],
          'rubro_empresa' => ['required'],
          'tipo_oportunidad' => ['required'],
          'terminos' => ['required']*/
        ]);
        $messages = [
          'empresa.required' => 'Debes completar en nombre de la empresa.',
          'trato_autoridad.required' => 'Debes completar el Trato de la autoridad.'
      ];
      
        $user->fill($request->only(
          'name',
          'email',
          'sexo',
          'ci',
          'telefono',
          'ciudad',
          'departamento',
          'direccion',
          'empresa',
          'descripcion_empresa',
          'url',
          'trato_autoridad',
          'nombre_autoridad',
          'trato_nexo',
          'nombre_nexo',
          'telefono_nexo',
          'correo_nexo',
          'direccion_nexo',
          'dias_atencion',
          'horario_atencion',
          'rubro_empresa',
          'tipo_oportunidad'
        ))->save();

        $user->fill(['terminos' => 1])->save();
        if(!empty($request->input('password')) && !empty($request->input('password_confirmation')) && $request->input('password') == $request->input('password_confirmation')) $user->fill([
            'password' => bcrypt($request->input('password'))
        ])->save();

        if ($request->file('logo')) {
            if ($user->logo) {
              Storage::delete('company/'.$user->logo);
            }
            $logo = $request->file('logo')->store('company');
            $logo = basename($logo);
            $user->fill(['logo' => $logo])->save();
        }

        session()->flash('success', '¡Tus datos han sido actualizados!');
        return redirect('mi-cuenta/editar');
      }
    }

    //session()->forget('success');

    if(!\Auth::user()) abort(401);
    
    return redirect('mi-cuenta/editar');
  }
  public function verify(Request $request)
  {

    $verifyUser = User::where('id', \Auth::user()->id)->first();
    
	if (!$verifyUser->empresa OR !$verifyUser->trato_autoridad OR !$verifyUser->nombre_autoridad OR !$verifyUser->trato_nexo OR !$verifyUser->nombre_nexo OR !$verifyUser->telefono_nexo OR !$verifyUser->correo_nexo OR !$verifyUser->url OR !$verifyUser->direccion_nexo) {
	session()->flash('success', 'Para solicitar perfil colaborador debes completar tus datos.');
	return redirect('mi-cuenta/editar?solicitud=editar');
	}

  	$findSolictud = Solicitud::where('user_id', \Auth::user()->id)->first();
  	if ($findSolictud) {
		if ($findSolictud->estado == 0) {
		//return 'Ya tienes una solicitud pendiente de aprobación.';
		session()->flash('success', 'Ya tienes una solicitud pendiente de aprobación, tu código de solicitud es "#'.$findSolictud->id.'"');
		return redirect('mi-cuenta/editar?solicitud=empresa');
		}
		if($findSolictud->estado == 1  AND !$verifyUser->isEmpresa()) {
		session()->flash('success', 'Ya posees una solicitud aprobada, pero por algún motivo te han retirado el perfil colaborador. Para cualquier consulta escribinos a hola@hallate.gov.py.');
		return redirect('mi-cuenta/editar');
		}
		if($findSolictud->estado == 1 AND $verifyUser->isEmpresa()) {
		session()->flash('success', 'Ya posees una solicitud aprobada y el perfil colaborador.');
		return redirect('mi-cuenta/editar');
		}
	}
  
    session()->flash('success', 'Por favor, verificá tus datos para confirmar la solicitud.');
    return redirect('mi-cuenta/editar?solicitud=editar');
    
  }

  public function deleteOferta($id)
  {
    $favorite     = Favorite::where('oferta_id', $id)->get();
    $relationship = DB::table('categories_relationships')->get();
    $tags         = DB::table('taggables')->where('taggable_id', $id)->where('taggable_type', 'ofertas')->get();
    if ($tags) {
      DB::table('taggables')->where('taggable_id', $id)->where('taggable_type', 'ofertas')->delete();
    }
    if ($favorite) {
      DB::table('favorites')->where('oferta_id', $id)->delete();
    }
    if ($relationship) {
      DB::table('categories_relationships')->where('parent_id', $id)->where('type', 3)->delete();
    }
    $oferta = Oferta::findOrFail($id);
    $oferta->delete();
    session()->flash('success', 'La oferta ha sido eliminada.');
    return redirect(route('mi-cuenta.ofertas'));
  }

  public function empresa(Request $request)
  {

    /*

    Solicitud de perfil colaborador/empresa

    */
    if (\Auth::user()->isEmpresa()){
    	session()->flash('success', 'Ya posees el perfil colaborador.');
    	return redirect('mi-cuenta/editar');
    } 
    $findSolictud = Solicitud::where('user_id', \Auth::user()->id)->first();
    $verifyUser = User::where('id', \Auth::user()->id)->first();
  	if ($findSolictud) {
		if ($findSolictud->estado == 0) {
		//return 'Ya tienes una solicitud pendiente de aprobación.';
		session()->flash('success', 'Ya tienes una solicitud pendiente de aprobación, tu código de solicitud es "#'.$findSolictud->id.'"');
		return redirect('mi-cuenta/editar');
		}
		if($findSolictud->estado == 1  AND !$verifyUser->isEmpresa()) {
		session()->flash('success', 'Ya posees una solicitud aprobada, pero por algún motivo te han retirado el perfil colaborador. Para cualquier consulta escribinos a hola@hallate.gov.py.');
		return redirect('mi-cuenta/editar');
		}
		if($findSolictud->estado == 1 AND $verifyUser->isEmpresa()) {
		session()->flash('success', 'Ya posees una solicitud aprobada y el perfil colaborador.');
		return redirect('mi-cuenta/editar');
		}
	}


    $request->validate([
    	'name' => 'required',
  		'email' => 'email|unique:users,email,'.\Auth::user()->id,
  		'ci' => 'required',
  		'telefono'=> 'required',
  		'direccion' => 'required',
      'empresa' => 'required',
      'trato_autoridad' => ['required'],
      'nombre_autoridad' => ['required'],
      'trato_nexo' => ['required'],
      'nombre_nexo' => ['required'],
      'telefono_nexo' => ['required'],
      'correo_nexo' => ['required'],
      'url' => ['required'],
      'direccion_nexo' => ['required'],
      'rubro_empresa' => ['required'],
      'tipo_oportunidad' => ['required'],
      'terminos' => ['required']
    ]);
    $messages = [
	    'empresa.required' => 'Debes completar en nombre de la empresa.',
	    'trato_autoridad.required' => 'Debes completar el Trato de la autoridad.'
	];

    



    if (\Auth::user()) {

		$input = Input::except('_token');

		$user = $this->users->findOrFail(\Auth::user()->id);
		if (empty($input)) {
		$input = $user;
		}

	      
	    $user->fill($request->only(
	      'name',
	      'email',
        'sexo',
	      'ci',
	      'telefono',
        'ciudad',
          'departamento',
	      'direccion',
	      'empresa',
	      'descripcion_empresa',
	      'url',
	      'trato_autoridad',
	      'nombre_autoridad',
	      'trato_nexo',
	      'nombre_nexo',
	      'telefono_nexo',
	      'correo_nexo',
	      'direccion_nexo',
	      'dias_atencion',
	      'horario_atencion',
	      'rubro_empresa',
	      'tipo_oportunidad'
	    ))->save();
	    
	    $user->fill(['terminos' => 1])->save();
	    if ($request->file('logo')) {
            if ($user->logo) {
              Storage::delete('company/'.$user->logo);
            }
            $logo = $request->file('logo')->store('company');
            $logo = basename($logo);
            $user->fill(['logo' => $logo])->save();
        }
        
      
      

		$solicitud = new Solicitud;
		$solicitud->mensaje = $request->mensaje;
		$solicitud->user_id = \Auth::user()->id;
		$solicitud->estado  = 0;
		$solicitud->save();
		//return $input;


		/*
		Mail para informar a hallate de una nueva solicitud
		*/
		Mail::send('emails.solicitud', ['input' => $input], function($message) use ($input)
		{
		$message->subject('Solicitud de perfil colaborador');
		$message->to(options('email'));
    $message->to(options('cc'));
		$message->from($input['email'], $input['name']);
		});

		/*
		Mail para informar al usuario que su silicitud esta procesada
		*/
		Mail::send('emails.solicituduser', ['input' => $input], function($message) use ($input)
		{
		$message->subject('Solicitud de perfil colaborador');
		$message->to($input['email']);
		$message->from('no-reply@hallate.gov.py', 'Hallate.gov.py');
		});

		session()->flash('success', 'Su solicitud ha sido procesada y esta pendiente de aprobación.');
		session()->flash('messages', $messages);
		return redirect('mi-cuenta/editar?solicitud=empresa');
       
    }
    else {
      abort(401);
    }

  }

}

  

