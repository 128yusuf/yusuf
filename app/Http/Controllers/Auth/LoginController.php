<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->role == config('constant.roles')['Shop']) //Set Redirect After Logged in If Role Shop
            return redirect()->route('products');
        else
            return redirect()->route('user.product');
    }
//    protected function redirectTo()
//    {
//        $role = Auth::user()->role;
//        $language = Auth::user()->language;
//        $this->redirectTo = route('user.product');
//
//        if($role == config('constant.roles')['Shop']){ //Set Redirect After Logged in If Role Shop
//            $this->redirectTo = route('products');
//        }
//
//        if($language == 'nl'){ //Set Redirect After Logged in If Role Shop
//            App::setLocale('nl');
//        }
//
//
//        return $this->redirectTo;
//    }
}
