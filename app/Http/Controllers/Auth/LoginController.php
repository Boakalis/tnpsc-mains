<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
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

    public function showLoginForm(){
        return view('login');
    }

    public function loginAttempt(Request $request)
    {

        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8|max:24',
            ],
            [
                'email.required' => 'Please Enter Email-address',
                'email.email' => 'Please provide valid email-address',
                'password.required' => 'Password is required',
            ]
        );

        $user=User::where('email',$request->email)->first();
        if($user !=  null){
            if (  $user->user_type == 1 || $user->user_type ==2) {
                if (Hash::check( $request->password , $user->password )) {
                    Auth::login($user);
                    return redirect()->route('dashboard')->with(Session::flash('welcome','Welcome'));
                }else{
                    return redirect()->route('login')->with(Session::flash('invalid-credentials','invalid-credentials')) ;
                }

            }else{
                return redirect()->route('login')->with(Session::flash('no-permission','no-permission')) ;
            }
        }else{
            return redirect()->route('login')->with(Session::flash('no-user','no-user')) ;
        }

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
