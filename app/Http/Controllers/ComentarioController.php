<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // dd($post->id); // se muestra el id del post para verificar que se ha recibido correctamente el post al método store del controlador ComentarioController. Esto es útil para asegurarse de que se está recibiendo la información correcta del post al intentar almacenar un nuevo comentario asociado a ese post.

        //Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);


        // Alamcenar

        Comentario::create([
            'user_id' => auth()->user()->id, // se obtiene el id del usuario autenticado utilizando auth()->user()->id para asociar el comentario con el usuario que lo ha creado.
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Lo equivalente, usando la relación
        /*****************************************
        $post->comentarios()->create([
            'user_id' => auth()->user()->id,
            'comentario' => $request->comentario
        ]);
        *****************************************/



        // Imprimir un mensaje
        return back()->with('mensaje','Comentario Realizado Correctamente');// se redirige al usuario a la página anterior utilizando back() después de almacenar el comentario, y se pasa un mensaje de éxito utilizando with() para mostrar una notificación al usuario indicando que el comentario se ha realizado correctamente. Los whith() se imprimen con una variable de sesión, por lo que se pueden mostrar en la vista utilizando la sintaxis de sesión para mostrar el mensaje al usuario.


    }
}
