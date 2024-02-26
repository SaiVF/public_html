<?php



namespace App\Http\Controllers\Backend;



use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Departamento;
use Auth;
use App\Solicitud;
use App\Http\Requests;
use Image;
use Mail;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller

{

	protected $users;

	

    public function __construct(User $users)

	{

		$this->users = $users;

        $this->roles = DB::table('roles')->orderBy('id')->pluck('name', 'id');

		

		//parent::__construct();
        $this->middleware('auth');
	}

	

	public function index(Request $request)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
		
		$users = User::where('departamento', '!=', NULL)->where('role', '!=', 3)->groupBy('departamento')->pluck('departamento');
		//return $users;
		$departamentos = Departamento::select('id as value', 'nombre as label')->whereIn('id', $users)->get();
		//return $departamentos;



        return view('backend.users.index', compact('departamentos'));

    }
    public function usersData(Request $request)
	{

	$request->user()->authorizeRoles(['administrador', 'moderador']);
	
	$users = $this->users->with('roles')->with('departamentos')->orderBy('created_at');
	
	return DataTables::of($users)->addColumn('action', function ($user) {
	            return '<a href="'.route('users.edit', $user->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a><a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-name="'.$user->name.'" data-route="'.route('users.destroy', $user->id).'"><span class="fa fa-close"></span> Eliminar</a>';
	        })->addColumn('perfil', function ($user) {
	        	$image = '';
	        	if($user->image){
		            if($user->provider == 'facebook'){
		            	$image = '<img class="thumbnail thumbnail-xs" src="'.url($user->image).'">';
		            }else{
		            	$path = url('/uploads/'.$user->image);
		            	$image = '<img class="thumbnail thumbnail-xs" src="'.$path.'">';
		            }
	            }
	            return $image;
	        })->addColumn('departamento_name', function ($user) {
	        	
	            return empty($user->departamentos) ? '-' : $user->departamentos->nombre;
	        })->rawColumns(['perfil', 'action'])->make(true);
	}
	public function empresasData(Request $request)
	{

	$request->user()->authorizeRoles(['administrador', 'moderador']);

	
	$users = $this->users->with('roles')->where('role', '=', 3)->orderBy('created_at');

	return DataTables::of($users)->addColumn('action', function ($user) {
	            return '<a href="'.route('users.edit', $user->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Editar</a><a href="#" class="btn btn-xs btn-danger btn-delete" data-toggle="modal" data-target="#modal-default" data-name="'.$user->name.'" data-route="'.route('users.destroy', $user->id).'"><span class="fa fa-close"></span> Eliminar</a>';
	        })->addColumn('perfil', function ($user) {
	        	$image = '';
	        	if($user->image){
		            if($user->provider == 'facebook'){
		            	$image = '<img class="thumbnail thumbnail-xs" src="'.url($user->image).'">';
		            }else{
		            	$path = url('/uploads/'.$user->image);
		            	$image = '<img class="thumbnail thumbnail-xs" src="'.$path.'">';
		            }
	            }
	            return $image;
	        })->editColumn('verify', function ($user) {
	        	$verify = '';
	        	if($user->verify == 1){
		            $verify = '<i class="fa fa-star text-yellow" title="Empresa verificada"></i>';
	            }else{
	            	$verify = '<i class="fa fa-star-o text-yellow" title="Empresa no verificada"></i>';
	            }
	            return $verify;
	        })->addColumn('departamento_name', function ($user) {
	        	
	            return empty($user->departamentos) ? '-' : $user->departamentos->nombre;
	        })->rawColumns(['perfil', 'action', 'verify'])->make(true);
	}
	public function usersExcel($type)
	{
		$type = $type;
		$hoy = Carbon::today();
    	$hoy = $hoy->format('Y-m-d');
		$name = 'Listado de ' . $type . ' hallate - '.$hoy. ' '.time();

		
		Excel::create($name, function($excel, $type) {
            $excel->sheet($type, function($sheet) {
                if($type == 'empresas'){
					$usuarios = User::where('role', 3)->get();
				}
				else{
					$usuarios = User::where('role', 3)->get();
				}
                $sheet->fromArray($usuarios);
            });
        })->export('xls');
	}



    public function solicitudes(Request $request)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);


		$solicitudes = Solicitud::where('estado', 0)->where('deleted', 0)->orderBy('created_at', 'DESC')->get();



        return view('backend.users.solicitudes', compact('solicitudes'));

    }



    public function denegar(Request $request, $id, $user_id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
		if (!\Auth::user()->isAdmin()) abort(401);

		$solicitud = Solicitud::find($id);
		$solicitud->deleted 	= 1;
		$solicitud->save();

		$input = User::find($user_id);

		



		/*

        	Mail para informar al usuario que su silicitud esta denegada

	    */

		Mail::send('emails.denegar', ['input' => $input], function($message) use ($input)

		{

			$message->subject('Solicitud de perfil colaborador');

			$message->to($input['email']);

			$message->from('no-reply@hallate.gov.py', 'Hallate.gov.py');

		});



        return redirect(route('backend.users.solicitudes'));

    }



    public function empresas(Request $request)

	{

		$request->user()->authorizeRoles(['administrador', 'moderador']);
		$users = User::where('departamento', '!=', NULL)->where('role', 3)->groupBy('departamento')->pluck('departamento');
		//return $users;
		$departamentos = Departamento::select('id as value', 'nombre as label')->whereIn('id', $users)->get();
		//return $departamentos;
		
        return view('backend.users.empresas', compact('departamentos'));
    }

    

    

    public function create(Request $request, User $user)

    {
    	$request->user()->authorizeRoles(['administrador', 'moderador']);


		$roles = $this->roles;

		$departamentos = DB::table('departamentos')->pluck('nombre', 'id');

		$sexo = config('cms.sexo');



		return view('backend.users.form', compact('user', 'roles', 'departamentos', 'sexo'));

	}

	

	public function store(Requests\StoreUserRequest $request)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);

		if (\Auth::user()->role == 4 AND $request->input('role') == 2) {
			return redirect(route('users.create'))->with('status', 'No puedes crear un usuario con un nivel más que el tuyo.')->withInput();
		}

		$user = $this->users->create($request->only(
			'name',
			'email',
			'role',
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
		));

    	$user->fill(['password' => bcrypt($request->input('password'))])->save();

		if(!empty($request->file('image'))) {
    	    $imageName = slug($user->name).'-'.time() . '.' .$request->file('image')->getClientOriginalExtension();
    	    $request->file('image')->move(base_path() . '/public/uploads/', $imageName);
			Image::make(base_path() . '/public/uploads/' . $imageName)->fit(360, 360, function ($constraint) {
			    $constraint->upsize();
			    $constraint->aspectRatio();
			})->encode('jpg', 60)->save();

			$user->fill(['image' => $imageName])->save();
		}

		

		return redirect(route('users.index'))->with('status', 'El usuario ha sido creado');
	}

	

	public function edit(Request $request, $id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
		
		$user = $this->users->findOrFail($id);

        $roles = $this->roles;

        $departamentos = DB::table('departamentos')->pluck('nombre', 'id');



        $sexo = config('cms.sexo');

		

		return view('backend.users.form', compact('user', 'roles', 'departamentos', 'sexo'));

	}

	

	public function update(Requests\UpdateUserRequest $request, $id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
		
		$user = $this->users->findOrFail($id);

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

		if(!empty($request->input('password')) && !empty($request->input('password_confirmation')) && $request->input('password') == $request->input('password_confirmation')) $user->fill([
            'password' => bcrypt($request->input('password'))
        ])->save();

		if (\Auth::user()->role == 4 AND $request->input('role') == 2) {
			return redirect(route('users.edit', $user->id))->with('status', 'No puedes elevar tu nivel de permisos.');
		}else {
			$user->fill([
	            'role' => $request->input('role')
	        ])->save();
		}


		if(!empty($request->file('image'))) {
            /*$imageName = slug($user->name).'-'.time() . '.' .$request->file('image')->getClientOriginalExtension();
   
            $request->file('image')->move(base_path() . '/public/uploads/', $imageName);
            Image::make(base_path() . '/public/uploads/' . $imageName)->fit(360, 360, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->encode('jpg', 60)->save();*/
            
            if ($user->image) {
              Storage::delete($user->image);
            }
            $image = $request->file('image')->store('');
            $image = basename($image);
            $user->fill(['image' => $image])->save();

            

            //$user->fill(['image' => $imageName])->save();

 		}

 		if ($request->verify) {
 			$verify = 1;
 		}else {
 			$verify = 0;
 		}

 		$user->fill(['verify' => $verify])->save();

		return redirect(route('users.edit', $user->id))->with('status', 'El usuario ha sido actualizado');
	}

	

	public function destroy(Request $request, $id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
    	if($id == Auth::user()->id) return back()->with('status', 'No se puede eliminar el actual usuario');



		$user = $this->users->findOrFail($id);



		$nameUser = $user->name;

		

		$user->delete();

		

		return redirect(route('users.index'))->with('status', 'El usuario '.$nameUser.' ha sido eliminado');

	}

	

	public function show($id)

	{

	}





	public function solicitudView(Request $request, $id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);

		$user = $this->users->findOrFail($id);



		return view('backend.users.solicitud', compact('user'));

	}

	public function solicitud(Request $request, $id)

	{
		$request->user()->authorizeRoles(['administrador', 'moderador']);
		$user = User::find($id);
		$solicitud = Solicitud::where('estado', 0)->where('deleted', 0)->where('user_id', $id)->first();
		if ($user->role == 3 AND $solicitud->estado === 0 AND $solicitud->deleted === 0) {
			$solicitud->estado = 1;
			$solicitud->save();
			return redirect()->back()->with('status', 'El usuario ya posee el perfil empresa, la solicitud ha sido elminada de esta lista.');
		}

		if ($user->role === 3) {
			return redirect()->back()->with('status', 'El usuario ya posee el perfil empresa.');
		}else {
			$user->role = 3;
			$user->save();
			$user->fill($request->only('role'))->save();

		}
		


		if (empty($solicitud)) {
			return redirect()->back()->with('status', 'El usuario ya posee el perfil empresa.');
		}else {
			$solicitud->estado = 1;
			$solicitud->approved = Auth::user()->id;
			$solicitud->save();
			$input = Input::all();

			Mail::send('emails.aprobacion', ['input' => $input], function($message) use ($input)
			{
				$message->subject('Solicitud aprobada');
				$message->to($input['email']);
				$message->from('no-replay@hallate.gov.py', 'Hallate');
			});



			return redirect(route('users.index'));

		}



		



	}



}