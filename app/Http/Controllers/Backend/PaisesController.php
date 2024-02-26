<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;
use App\Oferta;
use App\Child;
use App\Category;
use App\Pais;
use App\Http\Requests;

use Illuminate\Support\Facades\Storage;


class PaisesController extends Controller

{



  public function __construct(Oferta $ofertas, Child $children, Category $categories, Pais $paises)

  {

    $this->ofertas = $ofertas;

    $this->children = $children;

    $this->categories = $categories;

    $this->paises = $paises;
    $this->middleware('auth');

  }

  

  public function index(Request $request)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $paises = $this->paises->orderBy('nombre')->get();



    return view('backend.paises.index', compact('paises'));

  }

  

  public function create(Request $request, Oferta $oferta)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);




    return view('backend.pais.form', compact('oferta'));

  }

  

  public function store(Requests\StorePaisRequest $request)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $pais = $this->ofertas->create($request->only(

      'nombre',

      'name',

      'nom',

      'iso2',

      'iso3'

    ));



    $file = $request->file;



    if ($file)

    {

      $pais->icon       =$request->file('file')->store('uploads');



    }else {

      $pais->icon       = $pais->icon;

    }





    return redirect(route('paises.edit', $pais->id))->with('status', 'La entrada ha sido creada');

  }

  

  public function edit(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $pais = $this->paises->findOrFail($id);







    return view('backend.paises.form', compact('pais'));

  }



  public function update(Requests\UpdatePaisRequest $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $pais = $this->paises->findOrFail($id);

    

    $pais->fill($request->only(

      'nombre',

      'name',

      'nom',

      'iso2',

      'iso3'

    ))->save();

    $file = $request->file;



    if ($file)

    {

      if ($pais->icon) {

          Storage::delete($pais->icon);

      }

      



      $pais->fill([

        'icon' => $request->file('file')->store('icon')

      ])->save();



    }else {

      

    }



    



    return redirect(route('paises.edit', $pais->id))->with('status', 'La entrada ha sido actualizada');

  }

  

  public function confirm(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);

    $pais = $this->paises->findOrFail($id);

    

    return view('backend.paises.confirm', compact('pais'));

  }

  

  public function destroy(Request $request, $id)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    $oferta = $this->ofertas->findOrFail($id);

    $oferta->delete();

    

    return redirect(route('ofertas.index'))->with('status', 'La entrada ha sido eliminada');

  }

}

