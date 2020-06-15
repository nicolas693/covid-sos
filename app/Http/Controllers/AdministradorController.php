<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use App\UserType;

class AdministradorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::where('user_type', '<', $user->user_type)->get();
        return view('Administrador/index')
            ->with(
                'users',
                $users
            );
    }

    public function edit($id)
    {
        $user = User::find($id);
        $user_type = UserType::all()->pluck('tx_descripcion', 'id');
        return view('Administrador/edit')->with('user', $user)->with('user_type', $user_type);
    }

    public function update(Request $request)
    {
        $datos = $request->all();
        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $validatedData = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:' . $regLatino],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $datos['usuario_id']],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'email.unique' => 'Este correo electrónico ya está en uso!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
                'name.regex' => 'El nombre solo debe tener letras y espacios!',
                'password.confirmed' => 'Las contraseñas no coinciden!',
                'max' => 'Este campo no debe tener mas de :max caracteres !',
                'min' => 'Este campo debe tener al menos :min caracteres !'
            ]
        );

        $nueva_pw = '';
        $usuario = User::find($datos['usuario_id']);
        $usuario->name = $datos['name'];
        $usuario->email = $datos['email'];

        if (isset($datos['reset_password'])) {
            if ($datos['reset_password'] == '1') {
                $nueva_pw = substr($this->eliminar_acentos($datos['name']), 0, 2) . '.123456';
                $nueva_pw = $nueva_pw;
                $usuario->password = Hash::make($nueva_pw);
            }
        }
        $usuario->save();
        return 'usuario_actualizado';
    }

    public function eliminar_acentos($cadena)
    {

        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }
}
