<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidarPassword;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function getCambiarPassword($id)
    {   
        $user = User::find($id);
        return view('Password/cambiarPassword')->with('user',$user);
    }

    public function cambiarPassword(Request $request)
    {
        $datos = $request->all();
        $validatedData = $request->validate(
            [
                'password_a' => ['required', 'string', 'min:8', new ValidarPassword(request('usuario_id'))],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
               
                'password.confirmed' => 'Las contraseñas no coinciden!',
                'max' => 'Este campo no debe tener mas de :max caracteres !',
                'min' => 'Este campo debe tener al menos :min caracteres !'
            ]
        );
        $user = User::find($datos['usuario_id']);
        $user->password = Hash::make($datos['password']);
        $user->save();
        return 'password_actualizada';
    }
}
