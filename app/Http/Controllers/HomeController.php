<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Protege el controlador con el middleware auth. Cualquier usuario no autenticado que intente acceder a esa ruta será redirigido al login automáticamente.
     * Laravel tiene definida por defecto la ruta login en su sistema de autenticación. Cuando el middleware auth detecta que el usuario no está autenticado, redirige a route('login') automáticamente.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * __invoke() Es un método de PHP que permite llamar a un objeto como si fuera una función.
     * Laravel lo aprovecha para que cuando una ruta apunta directamente a un controlador sin especificar método, ejecute __invoke() automáticamente.
     * Es una convención para controladores que solo tienen una responsabilidad.
     */

    public function __invoke()
    {
        // Obtener a los usuarios a quienes seguimos

        /**
         * auth()->user()->followings  // trae la colección de usuarios que sigue el autenticado
         * ->pluck('id')               // de esa colección extrae solo los ids
         * ->toArray()                 // convierte el resultado a un array
         * */
        $ids = auth()->user()->followings->pluck('id')->toArray();

        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        //El método whereIn() verifica que el valor de una columna determinada esté contenido dentro del array dado. Con latest() ordena los post desde el mas nuevo al mas antiguo

        // dd($posts);

        return view('home', [
            'posts' => $posts //se pasa en la variable 'posts' los datos del array $posts que llegaran a la vista
        ]);
    }
}
