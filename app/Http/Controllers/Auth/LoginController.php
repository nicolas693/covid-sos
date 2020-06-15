<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Rules\RutValido;
use Auth;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $rut = '/^([0-9])+\-([kK0-9])+$/';
        $input = $request->all();

        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                recaptchaFieldName() => recaptchaRuleName()
            ],
            [
                'rut.required' => 'Este campo es obligatorio!',
                'email.required' => 'Este campo es obligatorio!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos y con digito verificador!',
                'password.required' => 'Este campo es obligatorio!',
                'recaptcha' => 'Debe demostrar que no eres un robot!'
            ]
        );

        // $fieldType = filter_var($request->rut, FILTER_VALIDATE_EMAIL) ? 'rut' : 'username';
        $fieldType = 'email';
        if (auth()->attempt(array($fieldType => $input['email'], 'password' => $input['password']))) {
            $user = Auth::user();
            if($user->user_type=='1'){
                return redirect()->route('home');
            }
            if($user->user_type=='2'){
                return redirect()->route('reclutador.index');
            }
            if($user->user_type=='3'){
                return redirect()->route('callcenter.index');
            }
            if($user->user_type=='4'){
                return redirect()->route('admin.index');
            }
           
        } else {
            return redirect()->route('login')
                ->with('error', 'Las credenciales no coinciden con los resgistros en la base de datos!');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logoutCurrentDevice();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
