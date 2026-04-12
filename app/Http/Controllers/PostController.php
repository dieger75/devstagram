<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // el middleware('auth') se encarga de verificar si el usuario está autenticado, si no lo está, lo redirige a la página de login, esto es necesario para proteger las rutas que requieren autenticación, en este caso, la ruta del muro donde se muestran los posts, ya que solo los usuarios autenticados pueden verlos
        $this->middleware('auth');
    }

    /**
     * Desde los Route:: en web.php  se le pasa el usuario al metodo "index" del controlador PostController, esto se hace con la sintaxis {user:username} en la ruta. Para ello debe añadirse aqui el model User como parametro con la variable identificativa del usuario $user
     */

    public function index(User $user)
    {   // dd($user); ---- informacion del usuario
        // dd($user->username);  ----- nombre del usuario

        return view('dashboard', [
            // se pasa el usuario a la vista del dashboard para mostrar su información en la vista (mirar la sintaxis de vista)
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }
}
