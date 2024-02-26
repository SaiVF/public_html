<?php

namespace App\Http\Controllers;

use App\Category;
use App\Oferta;
use App\Page;
use App\Favorite;
use App\Pais;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use AutoPresenter;
use DB;
use Mail;
use Carbon\Carbon;
use Validator;

    
class MainController extends Controller
{
  public function __construct(Page $pages, Oferta $ofertas, Category $categories)
  {
    $this->pages = $pages;
    $this->ofertas = $ofertas;
    $this->categories = $categories;
  }

  public function post($id, $slug)
  {
    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $post = AutoPresenter::decorate($this->ofertas->findOrFail($id));
    $posts = $this->ofertas->whereDate('fecha_inicio', '<=', $hoy)->whereDate('fecha_limite', '>=', $hoy)->where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('id', '!=', $id)->orderBy('created_at', 'desc')->take(4)->get();
    //$featured = $this->ofertas->where('featured', 1)->orderBy('created_at', 'desc')->take(4)->get();
    if (\Auth::user()) {
      $favorite = Favorite::where('oferta_id', $id)->where('user_id', \Auth::user()->id)->first();
    }

    return view('templates.post', compact('post', 'posts', 'favorite'));
  }

  public function lugar(Request $request)
  {
    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');

    $lugares = $this->ofertas->where(function($query) use ($hoy) {
                  $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
              })
              ->where('state', 1)
              ->where('deleted', 0)
              ->where('deleted', 0)
              ->where('borrador', 1)
              ->whereIn('id', DB::table('categories_relationships')
              ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
              ])->pluck('parent_id'))
              ->groupBy('lugar')
              ->orderBy('lugar')
              ->pluck('lugar');

    return view('partials.lugares', compact('lugares'));
  }

  public function content(Request $request)
  {
    $content = Category::where('id', $request->categoria)->first(); 

    return view('templates.categorycontent', compact('content'));
  }

  public function categorias(Request $request)
  {
    $categorias = Category::where('parent', $request->eje)->orderBy('name', 'ASC')->get(); 
    //return $request->eje;
    return view('partials.categorias', compact('categorias'));
  }

  public function forms(Request $request)
  {
    $form = Category::where('id', $request->categoria)->first();
    $paises = Pais::orderBy('nombre', 'ASC')->get();
    $temas = DB::table('select')->where('type', 'temas')->where('category_id', $request->categoria )->get();
    $template = 'forms.form';
    /*if($form->template)
    {
      $template = 'forms.'.$form->template;
    }*/
    
    return view($template, compact('paises', 'temas'));
  }

  public function temas(Request $request)
  {

    $temas = DB::table('select')->where('type', 'temas')->where('category_id', $request->categoria )->pluck('title', 'title');
    $temas->prepend('No aplica', 'No aplica');
    
    return view('partials.temas', compact('temas'));
  }
  public function niveles(Request $request)
  {
    
    $niveles = DB::table('select')->where('type', 'niveles')->where('category_id', $request->categoria)->pluck('title', 'title');
    $niveles->prepend('No aplica', 'No aplica');
    
    return view('partials.niveles', compact('niveles'));
  }

  public function tiempo(Request $request)
  {
    
    $tiempos = DB::table('select')->where('type', 'tiempo')->where('category_id', $request->categoria )->pluck('title', 'title');
    $tiempos->prepend('No aplica', 'No aplica');
    
    return view('partials.tiempo', compact('tiempos'));
  }
  public function financiamiento(Request $request)
  {
    
    $financiamientos = DB::table('select')->where('type', 'financiamiento')->where('category_id', $request->categoria )->pluck('title', 'title');
    $financiamientos->prepend('No aplica', 'No aplica');
    
    return view('partials.financiamiento', compact('financiamientos'));
  }

  public function financiamientoFilter(Request $request)
  {
    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $financiamiento = $this->ofertas
                      ->where('state', 1)
                      ->where('deleted', 0)
                      ->where('borrador', 1)
                      ->where('precio', '!=', '')
                      ->where('precio', '!=', '0')
                      ->whereIn('id', DB::table('categories_relationships')
                      ->select('parent_id')->where([
                      ['type', 3],
                      ['category_id', $request->categoria],
                      ])->pluck('parent_id'))
                      ->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                      })
                      ->orderBy('precio', 'asc')
                      ->groupBy('precio')->get();

    return view('partials.financiamientoFilter', compact('financiamiento'));

  }

  public function temaFilter(Request $request)
  {
    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $temas =  $this->ofertas
              ->where('state', 1)
              ->where('deleted', 0)
              ->where('borrador', 1)
              ->where('tema', '!=', '')
              ->whereIn('id', DB::table('categories_relationships')
                      ->select('parent_id')->where([
                      ['type', 3],
                      ['category_id', $request->categoria],
                      ])->pluck('parent_id'))
              ->where(function($query) use ($hoy) {
                  $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
              })
              ->orderBy('tema', 'asc')
              ->groupBy('tema')->get();
    return view('partials.temaFilter', compact('temas'));
  }



  public function buscar(Request $request, $parent = NULL)
  {
    
    $input = $request->all();


    $validator = Validator::make($input, [
        'q' => 'max:255|string|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
    ]);

    if ($validator->fails()) {
        return redirect('/')
                    ->withErrors($validator)
                    ->withInput();
    }

    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    if ($request->parent) {
      $allcategories = Category::where('id', $request->parent)->get();
    }else{
      $allcategories  = Category::whereNull('parent')->orderBy('order', 'ASC')->get();
    }
    $paises_exists = DB::table('ofertas')->where('state', 1)->where('borrador', 1)->where('deleted', 0)->select('pais_id')->where('pais_id', '!=', NULL)->where('pais_id', '!=', '')->pluck('pais_id');
    $paises = Pais::whereIn('id', $paises_exists)->get();
    $departamentos = DB::table('ofertas')->where('state', 1)->where('borrador', 1)->where('deleted', 0)->select('departamento')->where('departamento', '!=', NULL)->where('departamento', '!=', '')->where('pais_id', 179)->groupBy('departamento')->pluck('departamento');


    if (!empty($input['q']) AND empty($input['lugar']) AND empty($request->categoria) AND empty($request->financiamiento) AND empty($request->tema) AND empty($request->pais) AND empty($request->departamento)) {
      //return 'q';
      if (getUserIP()) {
        $client_ip = getUserIP();
      }
      if (\Auth::user()) {
        $user_id = \Auth::user()->id;
      }else {
        $user_id = NULL;
      }
      if ($request->header('User-Agent')) {
        $client_agent = $request->header('User-Agent');
      }else {
        $client_agent = NULL;
      }
      $origin = $request->header('Origin') ? $request->header('Origin') : NULL;
      $referer = $request->header('Referer') ? $request->header('Referer') : NULL;
      $parameter = $input['q'];
      $date_time = date('Y-m-d H:i:s');

      $sarch_history = DB::table('search_history')->insert(['parameter' => $parameter, 'client_ip' => $client_ip, 'client_agent' => $client_agent, 'origin' => $origin, 'referer' => $referer, 'user_id' => $user_id, 'created_at' => $date_time]);


      $tags = DB::table('tags')->where('name', 'LIKE', "%{$input['q']}%")->pluck('id');
      $ofertas_tags = DB::table('taggables')->where('taggable_type', 'ofertas')->whereIn('tag_id', $tags)->pluck('taggable_id');
      $categories_posibles = DB::table('categories')->where('name', 'LIKE', "%{$input['q']}%")->orWhere('related_words', 'LIKE', "%{$input['q']}%")->get();

      $search_hijo = DB::table('categories')->whereIn('parent', $categories_posibles->where('parent', NULL)->pluck('id'))->pluck('id');
      $clear_categories = $categories_posibles->where('parent', '!=', NULL)->pluck('id');
      $categories_ofertas = DB::table('categories_relationships')->whereIn('category_id', $clear_categories)->orWhereIn('category_id', $search_hijo)->pluck('parent_id');


      $ofertas = $this->ofertas
      ->where('state', 1)
      ->where('deleted', 0)
      ->where('borrador', 1)
      ->where(function($query) use ($hoy) {
          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
      })
      ->whereRaw('MATCH(title, lugar, lugar_aplicar, source) AGAINST ("%'.$input['q'].'%")')
      ->orWhereIn('id', $ofertas_tags)
      ->orWhereIn('id', $categories_ofertas)
      ->orderBy('fecha_limite', 'desc')
      ->paginate(15);
      

    }elseif (!empty($input['todo']) AND empty($input['q']) AND empty($input['lugar']) AND empty($request->categoria)) {
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('fecha_limite', 'desc')->paginate(15);


    }elseif (empty($input['todo']) AND empty($input['q']) AND empty($input['lugar']) AND empty($request->categoria) AND !empty($request->parent)) {
      //return 'ok';
      // Cuando se hace click en unas de las categorías de la home
      $categories = Category::where('parent', $request->parent)->orWhere('id', $request->parent)->get()->pluck('id');

      $parent = DB::table('categories_relationships')->select('parent_id')->whereIn('category_id', $categories)->where('type', 3)->pluck('parent_id');

      $ofertas = $this->ofertas
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->whereIn('id', $parent)
                ->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->orderBy('fecha_limite', 'desc')
                ->paginate(15);

      $category = Category::where('id', $request->parent)->first();
      

    }elseif (empty($input['todo']) AND empty($input['q']) AND empty($input['lugar']) AND !empty($request->categoria) AND empty($request->parent) AND empty($input['financiamiento']) AND empty($input['tema']) AND empty($request->pais) AND empty($request->departamento)){
     

      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif(empty($input['todo']) AND empty($input['q']) AND empty($input['lugar']) AND empty($request->categoria) AND empty($request->parent) AND !empty($request->sincosto) AND empty($input['financiamiento']) AND empty($input['tema'])){

      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('precio', 'Sin costo')
                ->orWhere('precio', '')
                ->orderBy('fecha_limite', 'desc')
                ->paginate(15);

    }elseif(empty($input['todo']) AND empty($input['q']) AND !empty($input['lugar']) AND !empty($request->categoria) AND empty($request->parent) AND empty($request->sincosto) AND empty($input['financiamiento']) AND empty($input['tema'])){

      // Cuando la busqueda se hace desde el búscador principal de la home

      $categories = Category::where('parent', $request->categoria)->orWhere('id', $request->categoria)->get()->pluck('id');

      $parent = DB::table('categories_relationships')->select('parent_id')->whereIn('category_id', $categories)->where('type', 3)->pluck('parent_id');

      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('lugar', 'LIKE', "%{$input['lugar']}%")
                ->whereIn('id', $parent)
                ->orderBy('fecha_limite', 'desc')
                ->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND !empty($input['tema']) AND !empty($input['pais']) AND !empty($input['departamento'])){
      
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('tema', 'LIKE',$input['tema'])
                ->where('precio', 'LIKE',$input['financiamiento'])
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE',$input['departamento'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (empty($input['categoria']) AND !empty($input['financiamiento']) AND !empty($input['tema']) AND empty($input['pais']) AND empty($input['departamento'])){
      //return 'financiamiento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('precio', 'LIKE',$input['financiamiento'])
                ->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND empty($input['financiamiento']) AND !empty($input['tema']) AND empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - tema';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('tema', 'LIKE',$input['tema'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND !empty($input['tema']) AND empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - tema - financiamiento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('tema', $input['tema'])
                ->where('precio', $input['financiamiento'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND empty($input['tema']) AND empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - financiamiento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('precio', $input['financiamiento'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (empty($input['categoria']) AND empty($input['financiamiento']) AND !empty($input['tema']) AND empty($input['pais']) AND empty($input['departamento'])){
      //return 'tema';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('tema', $input['tema'])
                ->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND empty($input['financiamiento']) AND !empty($input['tema']) AND !empty($input['pais']) AND !empty($input['departamento'])){

      //return 'categoria - tema - pais - departamento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE', '%'.$input['departamento'].'%')
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND !empty($input['tema']) AND !empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - tema - financiamiento - pais';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE', '%'.$input['departamento'].'%')
                ->where('tema', $input['tema'])
                ->where('precio', $input['financiamiento'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - financiamiento - pais';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('precio', $input['financiamiento'])
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND !empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND !empty($input['departamento'])){
      //return 'categoria - financiamiento - pais - departamento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE', '%'.$input['departamento'].'%')
                ->where('precio', 'LIKE', '%'.$input['financiamiento'].'%')
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND !empty($input['departamento'])){
      //return 'categoria - pais - departamento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE', '%'.$input['departamento'].'%')
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (!empty($input['categoria']) AND empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND empty($input['departamento'])){
      //return 'categoria - pais';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->whereIn('id', DB::table('categories_relationships')
                ->select('parent_id')->where([
                ['type', 3],
                ['category_id', $request->categoria],
                ])->pluck('parent_id'))->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (empty($input['categoria']) AND empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND !empty($input['departamento'])){
      //return 'pais - departamento';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->where('departamento', 'LIKE', '%'.$input['departamento'].'%')
                ->orderBy('fecha_limite', 'desc')->paginate(15);

    }elseif (empty($input['categoria']) AND empty($input['financiamiento']) AND empty($input['tema']) AND !empty($input['pais']) AND empty($input['departamento'])){
      //return 'pais';
      $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('pais_id', $request->pais)
                ->orderBy('fecha_limite', 'desc')->paginate(15);

    }
    else{
    	
        $ofertas = $this->ofertas->where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('fecha_limite', 'desc')->paginate(15);

    }


    return view('templates.buscar', compact('ofertas', 'allcategories', 'category', 'paises', 'departamentos'));
  }

  public function contacto(Request $request)
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
        $response = array('text' => 'Ocurrió un erro con la confirmación del Recaptcha, por favor intenta de nuevo.', 'code' => '1');
        return $response;
      }
    }
    $input = Input::all();
    if ($input['nombre'] AND $input['email'] AND $input['telefono'] AND $input['mensaje'] AND $request->get('g-recaptcha-response')) {
    	 Mail::send('emails.contacto', ['input' => $input], function($message) use ($input)
	    {
	      $message->subject('Contacto');
	      $message->to(options('email'));
	      $message->to(options('cc'));
	      $message->from(options('email'), options('title'));
	    });
    	$response = array('text' => 'Gracias por tu mensaje. Te responderemos en breve', 'code' => '2');
    	return $response;
    }else {
    	$response = array('text' => 'Por favor, completá todos los campos', 'code' => '1');
    	return $response;
    }

   
    
  }
  public function meinteresa(Request $request)
  {

    if (\Auth::user()) {
      $user = \Auth::user()->id;

      $find = Favorite::where('user_id', $user)->where('oferta_id', $request->post)->first();

      if (!$find) {
        $favorite = new Favorite();
        $favorite->user_id            = $user;
        $favorite->oferta_id          = $request->post;
        $favorite->save();
        return 'null';
      }else{
        $favorite = Favorite::where('user_id', $user)->where('oferta_id', $request->post)->first();
        $favorite->delete();
        return 'delete';
      }
    }else {
      return 'login';
    }

  }

  public function destacados()
  {
    $vencer   = Carbon::today()->addDays(7);
    $vencer   = $vencer->format('Y-m-d');

    $hoy      = Carbon::today();
    $hoy      = $hoy->format('Y-m-d');
    $ofertas  = Oferta::where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->where('featured', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(24)
                ->get();
    return view('partials.ofertas', compact('ofertas'));
  }
  public function news()
  {
    $vencer   = Carbon::today()->addDays(7);
    $vencer   = $vencer->format('Y-m-d');

    $hoy      = Carbon::today();
    $hoy      = $hoy->format('Y-m-d');
    $ofertas    = Oferta::where(function($query) use ($hoy) {
                    $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite','=', NULL);
                })
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(12)
                ->get();
    return view('partials.ofertas', compact('ofertas'));
  }
  public function vencer()
  {
    $vencer   = Carbon::today()->addDays(7);
    $vencer   = $vencer->format('Y-m-d');

    $hoy      = Carbon::today();
    $hoy      = $hoy->format('Y-m-d');
    $ofertas     = Oferta::whereDate('fecha_limite', '<=', $vencer)
                ->whereDate('fecha_limite', '>=', $hoy)
                ->where('state', 1)
                ->where('deleted', 0)
                ->where('borrador', 1)
                ->orderBy('fecha_limite', 'DESC')
                ->limit(12)
                ->get();
    return view('partials.ofertas', compact('ofertas'));
  }

  public function postear(Request $request)
  {
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
        'url' => ['required'],
        'vacancias_disponibles' => 'required|numeric'
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

    ];

    $this->validate($request, $rules, $messages);


    
    
    if (\Auth::user()) {
      $user = \Auth::user()->id;
      $type = 3;
      $anonimo = 0;
      if(\Auth::user()->verify == 1)
      {
        $borrador = 1;
      }else {
        $borrador = 0;
      }
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

      if ($request->precio) {
        $financiamiento = $request->precio;
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

      $oferta = new Oferta();
      $oferta->source                   = 'EMPRESAS';
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
      $oferta->borrador                 = $borrador;
      $oferta->modalidad                = $request->modalidad ? $request->modalidad : NULL;
      $oferta->state                    = 1;
        
      $oferta->save();

      DB::table('categories_relationships')->insert([
        'category_id' => $request->category,
        'type' => 3,
        'parent_id' => $oferta->id
      ]);

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

      session()->flash('success', '¡Tu oferta ha sido enviada para aprobación!');
      return redirect(route('mi-cuenta.ofertas.edit', ['id' => $oferta->id]));
    }
    else {
      abort(500);
    }
  }


}