<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request->get('username'));

        // $request->request es la instancia de ParameterBag de Symfony que almacena los datos del cuerpo de la petición (POST). El método add() inyecta o sobreescribe parámetros en ese bag.

        // add() -  Sobreescribe el campo 'username' en el request con ese valor transformado a slug, esto es necesario porque el campo username es único en la base de datos y no puede tener espacios ni caracteres especiales, el método slug de la clase Str convierte una cadena en un formato adecuado para URLs, por ejemplo, "Mi Nombre" se convierte en "mi-nombre", esto es útil para generar usernames a partir del nombre del usuario
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validación de datos
        $this->validate($request, [
            //'name' => ['required', 'min:5'], esta es otra forma de escribir la validación, pero se prefiere la forma de abajo
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        // Crear el usuario con el modelo User
        User::create([
            'name' => $request->name,
            // solo se pasa el request->username porque el campo username ya se añadió al request con el valor del slug, por lo que el valor del campo username en la base de datos será el slug y no el valor original, esto es necesario porque el campo username es único en la base de datos y no puede tener espacios ni caracteres especiales
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        /**
         * auth() es un helper de Laravel que devuelve el Guard de autenticación. attempt() recibe un array de credenciales y hace dos cosas:
         * 1. Busca en la base de datos un usuario donde email coincida.
         * 2. Si lo encuentra, verifica que el password del request coincida con el hash almacenado (usando Hash::check() internamente).
         *
         * Si ambas condiciones se cumplen: inicia la sesión y devuelve true. Si no: devuelve false.
         * **/

        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);


        /** otra forma de autenticar */
        auth()->attempt($request->only('email', 'password'));


        // Redireccionar al usuario a la ruta de '/muro' (nombre de la ruta es post.index) después de registrarse, esto se puede hacer con el método redirect() de Laravel, que permite redirigir a una ruta específica, en este caso se redirige a la ruta 'login' que es la ruta de inicio de sesión, esto se hace para que el usuario pueda iniciar sesión después de registrarse

        return redirect()->route('post.index', auth()->user()->username);


    }
}
