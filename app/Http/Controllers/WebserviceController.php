<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WebserviceController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function snppRun(Request $request)
    {
    	$request->user()->authorizeRoles(['administrador']);
    	function utf($string = NULL){
			if ($string) {
				return mb_convert_encoding($string, 'ISO-8859-1','utf-8');
			}else {
				return '';
			}
		};

		$delete = Oferta::where('source', 'SNPP')->get();
		DB::table('categories_relationships')->where('type', 3)->whereIn('parent_id', $delete->pluck('id'));
		DB::table('taggables')->where('taggable_type', 'ofertas')->whereIn('taggable_id', $delete->pluck('id'));
		$delete = Oferta::where('source', 'SNPP')->delete();

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

		$ofertas = Oferta::where('source', 'SNPP')->where('state', 1)->where('deleted', 0)->get();
		foreach ($ofertas as $oferta) {
			DB::table('categories_relationships')->insert(
			    ['category_id' => 3, 'type' => 3, 'parent_id' => $oferta->id]
			);
		}

        return 'Ofertas cargadas exitosamente';
    }

    public function stpRun(Request $request)
    {
    	$request->user()->authorizeRoles(['administrador']);
    	function utf($string = NULL){
			if ($string) {
				return mb_convert_encoding($string, 'ISO-8859-1','utf-8');
			}else {
				return '';
			}
		};

    	$delete = Oferta::where('source', 'STP')->get();
		DB::table('categories_relationships')->where('type', 3)->whereIn('parent_id', $delete->pluck('id'));
		DB::table('taggables')->where('taggable_type', 'ofertas')->whereIn('taggable_id', $delete->pluck('id'));
		Oferta::where('source', 'STP')->delete();

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

		$ofertas = Oferta::where('source', 'STP')->where('state', 1)->where('deleted', 0)->get();

		foreach ($ofertas as $oferta) {
			
			DB::table('categories_relationships')->insert(
			    ['category_id' => 9, 'type' => 3, 'parent_id' => $oferta->id]
			);
		}
        return 'Ofertas cargadas exitosamente';
    }


	public function sfpRun(Request $request)
    {
    	$request->user()->authorizeRoles(['administrador']);

    	$delete = Oferta::where('source', 'SFP')->get();
		DB::table('categories_relationships')->where('type', 3)->whereIn('parent_id', $delete->pluck('id'));
		DB::table('taggables')->where('taggable_type', 'ofertas')->whereIn('taggable_id', $delete->pluck('id'));
		Oferta::where('source', 'SFP')->delete();

    	$data = json_decode(file_get_contents('http://datos.sfp.gov.py/api/rest/concursos/listByEstado/POSTULACI%C3%93N?orden=DESC&inicio=0&cantidad=180'));
    	$collection = collect($data);
    	//return $collection;
    	

    	//$timestamp= $collection['inicioPostulacion']/1000;
		//return date('d/m/Y H:i:s', $timestamp);
		//eturn gmdate("d m Y - h:m:s", $collection['inicioPostulacion']);

		foreach ($collection as $oferta) {
			$timestamp_inicio= $oferta->inicioPostulacion/1000;
			$timestamp_fin= $oferta->finPostulacion/1000;
			$inicio = date('Y-m-d', $timestamp_inicio);
			$fin = date('Y-m-d', $timestamp_fin);
			$title = $oferta->cargo;
			if (empty($title)) {
				$title = $oferta->puesto;
			}
			if (empty($title)) {
				$title = $oferta->clasificacionOcupacional;
			}
			if (empty($title)) {
				$title = 'Oportunidad Laboral SFP';
			}

			DB::table('ofertas')->insert(
			    ['title' => $title, 'source' => 'SFP', 'source_id' => $oferta->identificadorConcursoPuesto, 'fecha_inicio' => $inicio, 'fecha_limite' => $fin, 'lugar' => 'En el país', 'url' => $oferta->uri, 'nivel' => $oferta->descripcionNivel, 'vacancias_disponibles' => $oferta->vacancia, 'pais_id' => 179, 'state' => 1, 'deleted' => 0, 'borrador' => 1]
			);
			
		}

		$ofertas = Oferta::where('source', 'SFP')->where('state', 1)->where('deleted', 0)->get();

		foreach ($ofertas as $oferta) {
			
			DB::table('categories_relationships')->insert(
			    ['category_id' => 11, 'type' => 3, 'parent_id' => $oferta->id]
			);
		}
        return 'Ofertas cargadas exitosamente';
    }

    public function pivotRun(Request $request)
    {
    	$request->user()->authorizeRoles(['administrador']);
    	function utf($string = NULL){
  			if ($string) {
  				return mb_convert_encoding($string, 'ISO-8859-1','utf-8');
  			}else {
  				return '';
  			}
  		};
      $ar = json_decode(file_get_contents('https://www.pivot.com.py/ws/api/v1/Empleos?edadMin=18&edadMax=100'));
    	$collection = collect($ar);
    	foreach ($collection as $oferta) {
      		DB::table('ofertas')->insert(
  			    ['title' => $oferta->nombre, 'source' => 'PIVOT', 'source_id' => $oferta->orden, 'departamento' => $oferta->lugar, 'ciudad' => $oferta->lugar, 'url' => $oferta->accede_aca, 'fecha_inicio' => $oferta->fecha_de_inicio, 'fecha_limite' => $oferta->fecha_de_cierre, 'descripcion' => $oferta->descripcion, 'borrador' => 1, 'state' => 1, 'deleted' => 0]
  			);
      	}
      	$ofertas = DB::table('ofertas')->where('source', 'PIVOT')->get();
      	foreach ($ofertas as $oferta) {
  			DB::table('categories_relationships')->insert(
  			    ['category_id' => 14, 'type' => 3, 'parent_id' => $oferta->id]
  			);
  		}
		
    	return 'Ofertas cargadas exitosamente';
    }

}