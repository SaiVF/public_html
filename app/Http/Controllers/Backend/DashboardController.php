<?php

namespace App\Http\Controllers\Backend;

use App\Oferta;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['administrador', 'moderador']);

        $hoy = Carbon::today();
        $hoy = $hoy->format('Y-m-d');
        
        $oferta = Oferta::where('state', 1)->where('borrador', 1)->where('deleted', 0)->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->count();
        $inactivas = Oferta::where('state', 1)->where('borrador', 1)->where('deleted', 0)->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '<=', $hoy)->orWhere('fecha_limite', NULL);
                      })->count();
        $featured = Oferta::where('featured', 1)->where('state', 1)->where('borrador', 1)->where('deleted', 0)->count();
        $user   = User::count();
        $snpp   = Oferta::where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('source', 'SNPP')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->count();
        $stp   = Oferta::where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('source', 'STP')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->count();
        $sfp   = Oferta::where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('source', 'SFP')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);

                      })->count();
        $pivot   = Oferta::where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('source', 'PIVOT')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                          
                      })->count();
        $hallate   = Oferta::where('state', 1)->where('deleted', 0)->where('borrador', 1)->where('source', 'HALLATE')->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->count();
        $vacancias = Oferta::select('vacancias_disponibles')->where('deleted', 0)->where('borrador', 1)->where('state', 1)->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->sum('vacancias_disponibles');
        $empresas   = Oferta::where('source', 'EMPRESAS')->where('state', 1)->where('deleted', 0)->where('borrador', 1)->where(function($query) use ($hoy) {
                          $query->where('fecha_limite', '>=', $hoy)->orWhere('fecha_limite', NULL);
                      })->limit(10)->count();


        $categories = Category::whereNull('parent')->with('ofertas')->get();


        return view('backend.dashboard', compact('oferta', 'snpp', 'stp', 'sfp', 'hallate', 'featured', 'user', 'vacancias', 'inactivas', 'empresas', 'categories', 'pivot'));
    }
}
