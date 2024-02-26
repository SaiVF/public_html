<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class OptionsController extends Controller

{

  public function __construct()

  {

    $this->groups = config('cms.options');
    $this->middleware('auth');

  }

  

  public function index(Request $request)

  {

    $request->user()->authorizeRoles(['administrador', 'moderador']);

    foreach($this->groups as $key => $group) {

      $object[] = (object)[

        'key' => $key,

        'name' => $group,

        'options' => $options = DB::table('options')

          ->select('*')

          ->where('group', $key)

          ->orderBy('id')

          ->get()

      ];

    }

    

    return view('backend.options.index', compact('object'));

  }

  



  public function store(Request $request)

  {
    $request->user()->authorizeRoles(['administrador', 'moderador']);
    foreach($request->except('_token') as $key => $value) {

      DB::table('options')

        ->where('name', $key)

        ->update(['value' => $value]);

    }



    if(!empty($request->file())) {

      foreach($request->file() as $key => $file) {

        $imageName = $key.'.'.$file->getClientOriginalExtension();

    

        $file->move(base_path() . '/public/uploads/', $imageName);

        

        DB::table('options')

          ->where('name', $key)

          ->update(['value' => $imageName]);

      }

    }



    return redirect(route('options.index'))->with('status', 'Las opciones han sido actualizadas');

  }

}

