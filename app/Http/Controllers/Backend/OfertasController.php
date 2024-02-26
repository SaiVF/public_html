<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Oferta;
use App\Child;
use App\Pais;
use App\Category;
use App\Favorite;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Mail;
use Yajra\DataTables\DataTables;

class OfertasController extends Controller
{

  public function __construct(Oferta $ofertas, Child $children, Category $categories)
  {
    $this->ofertas = $ofertas;
    $this->children = $children;
    $this->categories = $categories;
    //parent::__construct();
    $this->middleware('auth');
    
  }
  
  public function index(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);

    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $ofertas = $this->ofertas->with('categories')->where('state', 1)->where('borrador', 1)->orderBy('created_at')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->get();
    //return $ofertas;
    $source = $this->ofertas->select('source as value', 'source as label')->groupBy('source')->get();

    return view('backend.ofertas.index', compact('ofertas', 'source'));
  }

  public function ofertasData(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);

    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $ofertas = $this->ofertas->with('user')->with('categories')->where('state', 1)->where('deleted', 0)->where('borrador', 1)->orderBy('created_at')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      });

    //return dd($ofertas);

    return DataTables::of($ofertas)->addColumn('action', function ($oferta) {
                return '<a href="'.route('ofertas.edit', $oferta->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-title="'.$oferta->title.'" data-route="'.route('backend.ofertas.destroy', $oferta->id).'"><span class="fa fa-close"></span> Eliminar</a>';
            })->editColumn('user', function ($oferta) {
            if ($oferta->user == null) {
              return ["name"=>"-"];
            }else {
              return ["name" => $oferta->user->name];
            }
          })->addColumn('featured', function ($oferta) {
                $checked = $oferta->featured ? 'checked' : '';
                return '<label class="custom-control custom-checkbox featured">
                        <input type="checkbox" class="custom-control-input" '.$checked.' data-id="'.$oferta->id.'">
                        <span class="custom-control-indicator"></span>
                    </label>';
            })->rawColumns(['featured', 'action'])->make(true);
  }

  public function vencidasData(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);

    $hoy = Carbon::today();
    $hoy = $hoy->format('Y-m-d');
    $ofertas = $this->ofertas->with('categories')->where('state', 1)->where('deleted', 0)->where('borrador', 1)->orderBy('created_at')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '<=', $hoy);
                      });

    return DataTables::of($ofertas)->addColumn('action', function ($oferta) {
                return '<a href="'.route('ofertas.edit', $oferta->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-title="'.$oferta->title.'" data-route="'.route('backend.ofertas.destroy', $oferta->id).'"><span class="fa fa-close"></span> Eliminar</a>';
            })->addColumn('featured', function ($oferta) {
                $checked = $oferta->featured ? 'checked' : '';
                return '<label class="custom-control custom-checkbox featured">
                        <input type="checkbox" class="custom-control-input" '.$checked.' data-id="'.$oferta->id.'">
                        <span class="custom-control-indicator"></span>
                    </label>';
            })->rawColumns(['featured', 'action'])->make(true);
  }

  public function borradores(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $ofertas = $this->ofertas->where('borrador', 0)->orderBy('created_at')->get();

    return view('backend.ofertas.borradores', compact('ofertas'));
  }
  public function vencidas(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    

    return view('backend.ofertas.vencidas');
  }
  public function altaoferta(Request $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = Oferta::findOrFail($id);
    $oferta->borrador = 1;
    $oferta->save();
    $user = User::findOrFail($oferta->owner);
    $email = $user->email;
    Mail::send('emails.borrador', ['email' => $email], function($message) use ($email)
    {
      $message->subject('Oferta aprobada');
      $message->to($email);
      $message->to(options('cc'));
      $message->from(options('email'), options('title'));
    });

    return redirect(route('backend.ofertas.borradores'))->with('status', 'La oferta ha sido aprobada');
  }
  
  public function create(Request $request, Oferta $oferta)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $files = null;
    $parents = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();
    $categories = $this->categories->whereNotIn('id', $this->categories->whereNotNull('parent')->pluck('parent'))->where('type', 3)->orderBy('name')->pluck('name', 'id');
    $marcas = $this->categories->where('type', 100)->orderBy('order')->pluck('name', 'id');
    $lugar = $this->ofertas->groupBy('lugar')->pluck('lugar', 'lugar');
    $paises = Pais::pluck('nombre', 'id');
    $modalidades = config('cms.modalidad');

    $niveles= DB::table('select')->where('type', 'niveles')->pluck('title', 'title');
    $temas= DB::table('select')->where('type', 'temas')->pluck('title', 'title');
    $tiempo= DB::table('select')->where('type', 'tiempo')->pluck('title', 'title');
    $financiamiento= DB::table('select')->where('type', 'financiamiento')->pluck('title', 'title');
    $niveles->prepend('No aplica', 'No aplica');
    $temas->prepend('No aplica', 'No aplica');
    $tiempo->prepend('No aplica', 'No aplica');
    $financiamiento->prepend('No aplica', 'No aplica');
    $departamentos = DB::table('departamentos')->pluck('nombre', 'nombre');
    $departamentos->prepend($oferta->departamento, $oferta->departamento);
    $departamentos->toArray();
    $tagss = DB::table('tags')->pluck('name', 'id');

    return view('backend.ofertas.form', compact('oferta', 'files', 'categories', 'marcas', 'lugar', 'paises', 'departamentos', 'niveles', 'temas', 'tiempo', 'financiamiento', 'modalidades', 'tagss'));
  }
  
  public function store(Requests\StoreOfertaRequest $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = $this->ofertas->create($request->only(
      'title',
      'fecha_inicio',
      'fecha_limite',
      'lugar',
      'lugar_aplicar',
      'descripcion',
      'requisito',
      'obs',
      'url',
      'precio',
      'pais_id',
      'owner',
      'inicio_aplicio',
      'cierre_aplicacion',
      'departamento',
      'ciudad',
      'contacto_con',
      'proceso_aplicacion',
      'uri_aplicacion',
      'nivel',
      'tema',
      'tiempo',
      'vacancias_disponibles',
      'beneficios',
      'modalidad'
    ));

    $user = \Auth::user()->id;

    $oferta->fill(['last_edit' => $user])->save();

    $oferta->fill([
      'featured' => !empty($request->input('featured')) ? 1 : NULL,
      'source' => 'HALLATE'
    ])->save();
        
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

    if ($request->tags) {
      foreach ($request->tags as $tag) {
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

    if(session()->has('children')) {
      foreach(session()->get('children') as $childName) {
        $this->children->create([
          'type' => 3,
          'parent_id' => $oferta->id,
          'src' => $childName
        ]);
      }
      session()->forget('children');
    }

    return redirect(route('ofertas.edit', $oferta->id))->with('status', 'La entrada ha sido creada');
  }
  
  public function edit(Request $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = $this->ofertas->findOrFail($id);
    if(!$oferta->theChildren()->isEmpty()) {
      foreach($oferta->theChildren() as $child) {
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
    $parents = $this->categories->where('type', 3)->whereNull('parent')->orderBy('order')->get();

    $categories = $this->categories->whereNotIn('id', $this->categories->whereNotNull('parent')->pluck('parent'))->where('type', 3)->orderBy('name')->pluck('name', 'id');
    $selected_categories = DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $oferta->id]
    ])->pluck('category_id');
    $marcas = $this->categories->where('type', 100)->orderBy('order')->pluck('name', 'id');
    $paises = Pais::pluck('nombre', 'id');
    $modalidades = config('cms.modalidad');

    $category_this = DB::table('categories_relationships')->where([
      ['type', 3],
      ['parent_id', $oferta->id]
    ])->pluck('category_id')->first();
    //
    $niveles= DB::table('select')->where('type', 'niveles')->where('category_id', $category_this)->pluck('title', 'title');
    $temas= DB::table('select')->where('type', 'temas')->where('category_id', $category_this)->pluck('title', 'title');
    $tiempo= DB::table('select')->where('type', 'tiempo')->where('category_id', $category_this)->pluck('title', 'title');
    $financiamiento= DB::table('select')->where('type', 'financiamiento')->where('category_id', $category_this)->pluck('title', 'title');
    $niveles->prepend($oferta->nivel, $oferta->nivel);
    $niveles->prepend('No aplica', 'No aplica');
    $temas->prepend($oferta->tema, $oferta->tema);
    $temas->prepend('No aplica', 'No aplica');
    $tiempo->prepend($oferta->tiempo, $oferta->tiempo);
    $tiempo->prepend('No aplica', 'No aplica');
    $financiamiento->prepend($oferta->precio, $oferta->precio);
    $financiamiento->prepend('No aplica', 'No aplica');
    $departamentos = DB::table('departamentos')->pluck('nombre', 'nombre');
    $departamentos->prepend($oferta->departamento, $oferta->departamento);
    $departamentos->toArray();
    $tags = DB::table('taggables')->where('taggable_id', $oferta->id)->pluck('tag_id');
    $selected_tags = DB::table('tags')->whereIn('id', $tags)->pluck('name');
    //return $selected_tags;
    //return $category_this;
    //$tags;
    $tagss = DB::table('tags')->pluck('name', 'name');
    //return $selected_categories;

    return view('backend.ofertas.form', compact('oferta', 'files', 'categories', 'marcas', 'selected_categories', 'paises', 'niveles', 'temas', 'tiempo', 'financiamiento', 'departamentos', 'modalidades', 'selected_tags', 'tagss'));
  }

  public function update(Requests\UpdateOfertaRequest $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = $this->ofertas->findOrFail($id);
    
    
    $oferta->fill($request->only(
      'title',
      'fecha_inicio',
      'fecha_limite',
      'lugar',
      'lugar_aplicar',
      'descripcion',
      'requisito',
      'obs',
      'url',
      'precio',
      'pais_id',
      'inicio_aplicacion',
      'cierre_aplicacion',
      'departamento',
      'ciudad',
      'contacto_con',
      'proceso_aplicacion',
      'uri_aplicacion',
      'nivel',
      'tema',
      'tiempo',
      'vacancias_disponibles',
      'beneficios',
      'modalidad'
    ))->save();

    $user = \Auth::user()->id;

    $oferta->fill(['last_edit' => $user])->save();

    $oferta->fill([
      'featured' => !empty($request->input('featured')) ? 1 : NULL
    ])->save();
    
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

    //$array = explode(",", $request->get('tags')[0]);
    if ($request->tags) {
      DB::table('taggables')->where('taggable_id', $oferta->id)->delete();

      foreach ($request->tags as $tag) {
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

    return redirect(route('ofertas.edit', $oferta->id))->with('status', 'La entrada ha sido actualizada');
  }
  
  public function confirm(Request $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = $this->ofertas->findOrFail($id);
    
    return view('backend.ofertas.confirm', compact('oferta'));
  }
  
  public function destroy(Request $request, $id)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
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
    $oferta = $this->ofertas->findOrFail($id);
    $oferta->delete();
    
    return redirect(route('ofertas.index'))->with('status', 'La entrada ha sido eliminada');
  }

  public function featured(Request $request)
  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $id = $request->id;
    $user = \Auth::user()->id;
    $oferta = $this->ofertas->findOrFail($id);
    if ($oferta->featured == 1) {
      $oferta->fill([
        'featured' => NULL,
        'last_edit' => $user
      ])->save();
      return 'Estado 0';
    }else {
      $oferta->fill([
        'featured' => 1,
        'last_edit' => $user
      ])->save();
      return 'Estado 1';
    }
    
  }
}
