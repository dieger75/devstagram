<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // dd($request->remember);

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // $request->remember es un valor booleano que indica si el usuario ha marcado la casilla "Mantener mi sesión abierta". Si el usuario ha marcado la casilla, $request->remember será true/on; de lo contrario, será false. Este valor se pasa como segundo argumento al método auth()->attempt() para indicar si la sesión del usuario debe mantenerse activa incluso después de cerrar el navegador.

        if(!auth()->attempt($request->only('email', 'password'), $request->remember)):
            // back()->with('mensaje', '..............') flashea un valor en la sesión — lo guarda temporalmente para la siguiente request y luego desaparece. Esto es útil para mostrar mensajes de error o éxito después de redirigir al usuario, en este caso, se muestra un mensaje de error si las credenciales son incorrectas.

            /**
             * Usuario envía formulario → POST /login
             * → credenciales incorrectas
             * → back() → regresa al formulario (GET /login)
             * → .with('mensaje', '...') → lleva ese dato consigo
             * → blade lee session('mensaje') → muestra el error
             */
            return back()->with('mensaje', 'Credenciales incorrectas');
        endif;


        return redirect()->route('post.index', auth()->user()->username );
    }
}
