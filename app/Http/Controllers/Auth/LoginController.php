<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function authenticated()
    {
        if (!auth()->user()->status)
        {
            $inputs = ['email' => auth()->user()->email];
            auth()->logout();
            return redirect('login')->withInput($inputs)->with('msg', __('customlang.compte_desactive_login'));
        }
    }

    protected function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email',$request->email)->first();
        if (Auth::attempt($credentials))
        {
            if ($user->status == 0)
            {
                Auth::logout();
                return redirect('login')->withInput($request->all())->with('msg', 'Votre compte est désactivé, veuillez contacter l\'administration de '. config('app.name') .' pour plus d\'information');
            }
            return redirect('/');
        }
        else
        {
            return redirect('login')->withInput($request->all())->with('msg', 'Login ou mot de passe incorrect !');
        }
    }
}
