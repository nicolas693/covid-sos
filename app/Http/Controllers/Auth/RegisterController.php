<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\RutValido;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rut = '/^([0-9])+\-([kK0-9])+$/';
        
        return Validator::make(
            $data,
            [
                'rut' => ['regex:' . $rut,new RutValido(request('rut')),'max:11', 'nullable'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
               
                'password.confirmed' => 'Las contraseñas no coinciden!',
                'max' => 'Este campo no debe tener mas de :max caracteres !'
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //dd($data);
        // $user = new User();
        // $user->rut = $data['rut'];
        // $user->name = $data['name'];
        // $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        // $user->save();

        // return view('auth/login');
        return User::create([
            'rut' => $data['rut'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
