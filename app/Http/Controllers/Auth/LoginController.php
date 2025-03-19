<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        // protected $redirectTo = '/dashbord';

        protected function redirectTo()
        {
            $user = auth()->user();
            if ($user->roles->pluck('name')->contains('admin'||'manager'||'super-admin')) {
                return '/dashbord';
            }
            return '/home';
        }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    protected function loggedOut(Request $request)
    {
        return redirect('/home');
    }
}
