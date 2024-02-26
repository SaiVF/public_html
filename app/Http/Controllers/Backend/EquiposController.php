<?php

namespace App\Http\Controllers\Backend;

use App\Equipo;
use App\Obra;
use App\Http\Requests;

class EquiposController extends Controller
{

  public function __construct(Equipo $equipos, Obra $obras)
  {
    $this->equipos = $equipos;
    $this->obras = $obras;
  }
  
  public function index()
  {
    $equipos = $this->equipos->orderBy('marca')->orderBy('modelo')->get();

    return view('backend.equipos.index', compact('equipos'));
  }
  
  public function create(Equipo $equipo)
  {
    return view('backend.equipos.form', compact('equipo'));
  }
  
  public function store(Requests\StoreEquipoRequest $request)
  {
    $equipo = $this->equipos->create($request->only(
      'codigo',
      'marca',
      'modelo',
      'ano',
      'chapa',
      'chasis',
      'ejes',
      'hp',
      'capacidad_carga',
      'capacidad_tanque',
      'peso',
      'color',
      'altura',
      'ancho',
      'largo',
      'filtro_aceite',
      'filtro_combustible',
      'filtro_aire_primario',
      'filtro_aire_secundario',
      'aceite_motor',
      'aceite_caja',
      'herramientas_desgaste',
      'engrasador'
    ));

    return redirect(route('equipos.edit', $equipo->id))->with('status', 'La entrada ha sido creada');
  }
  
  public function edit($id)
  {
    $equipo = $this->equipos->findOrFail($id);

    return view('backend.equipos.form', compact('equipo', 'obra'));
  }

  public function update(Requests\UpdateEquipoRequest $request, $id)
  {
    $equipo = $this->equipos->findOrFail($id);
    
    $equipo->fill($request->only(
      'codigo',
      'marca',
      'año',
      'chapa',
      'modelo',
      'ejes',
      'hp',
      'chasis',
      'capacidad_carga',
      'peso',
      'color',
      'altura',
      'ancho',
      'largo',
      'capacidad_tanque',
      'filtro_aceite',
      'filtro_combustible',
      'filtro_aire_primario',
      'filtro_aire_secundario',
      'aceite_motor',
      'aceite_caja',
      'herramientas_desgaste',
      'engrasador'
    ))->save();

    return redirect(route('equipos.edit', $equipo->id))->with('status', 'La entrada ha sido actualizada');
  }
  
  public function confirm($id)
  {
    $equipo = $this->equipos->findOrFail($id);
    
    return view('equipos.confirm', compact('equipo'));
  }
  
  public function destroy($id)
  {
    $equipo = $this->equipos->findOrFail($id);
    $equipo->delete();
    
    return redirect(route('equipos.index'))->with('status', 'La entrada ha sido eliminada');
  }
}
