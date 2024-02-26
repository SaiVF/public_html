<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Obra;
use App\Equipo;
use App\Http\Requests;
use DB;

class ObrasController extends Controller
{

  public function __construct(Obra $obras, Equipo $equipos)
  {
    $this->obras = $obras;
    $this->equipos = $equipos;
  }
  
  public function index()
  {
    $obras = $this->obras->orderBy('inicio', 'desc')->get();

    return view('backend.obras.index', compact('obras'));
  }
  
  public function create(Obra $obra)
  {
    return view('backend.obras.form', compact('obra'));
  }
  
  public function equipo(Request $request)
  {
    $obra = $this->obras->findOrFail($request->obra);
    $equipos_obj = $this->equipos->orderBy('marca')->orderBy('modelo')->get();
    $equipos = [];
    foreach($equipos_obj as $equipo) {
      $equipos[$equipo->id] = $equipo->marca.' '.$equipo->modelo.' '.$equipo->ano;
    }

    return view('backend.obras.equipo', compact('obra', 'equipos'));
  }
  
  public function asignar(Request $request)
  {
    DB::table('obras_relationships')->insert([
      'obra_id' => $request->obra,
      'equipo_id' => $request->equipo
    ]);

    return redirect(route('obras.edit', $request->obra))->with('status', 'El equipo ha sido asignado');
  }
  
  public function store(Requests\StoreObraRequest $request)
  {
    $obra = $this->obras->create($request->only(
      'nombre',
      'lugar',
      'inicio',
      'cierre',
      'cierre_final',
      'ubicacion',
      'ingeniero',
      'administrador'
    ));

    return redirect(route('obras.edit', $obra->id))->with('status', 'La entrada ha sido creada');
  }
  
  public function edit($id)
  {
    $obra = $this->obras->findOrFail($id);

    return view('backend.obras.form', compact('obra'));
  }

  public function update(Requests\UpdateObraRequest $request, $id)
  {
    $obra = $this->obras->findOrFail($id);
    
    $obra->fill($request->only(
      'nombre',
      'lugar',
      'inicio',
      'cierre',
      'cierre_final',
      'ubicacion',
      'ingeniero',
      'administrador'
    ))->save();

    return redirect(route('obras.edit', $obra->id))->with('status', 'La entrada ha sido actualizada');
  }
  
  public function confirm($id)
  {
    $obra = $this->obras->findOrFail($id);
    
    return view('backend.obras.confirm', compact('obra'));
  }
  
  public function destroy($id)
  {
    $obra = $this->obras->findOrFail($id);
    $obra->delete();
    
    return redirect(route('obras.index'))->with('status', 'La entrada ha sido eliminada');
  }
}
