<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectAfterLogout = route('login');
        //$this->redirectTo = url()->previous();
        $this->redirectTo = 'mi-cuenta';
        $this->middleware('guest')->except('logout');
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        if($authUser) {
          Auth::login($authUser, true);
          return redirect($this->redirectTo);
        } else {
          return redirect(route('login'))->with('status', 'La dirección de correo ya está siendo utilizada con otra cuenta');
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if($authUser) {
          return $authUser;
        }

        $email = $user->email;
        $user_exists = User::where('email', $user->email)->first();
        if($user_exists) return false;
        
        $user = User::create([
          'name'     => $user->name,
          'email'    => $user->email,
          'image'    => $user->avatar,
          'provider' => $provider,
          'provider_id' => $user->id
        ]);

        return $user;
    }

    protected function redirectTo()
    {
        return Auth::user()->isAdmin() ? '/backend/dashboard' : $this->redirectTo;
    }
}
