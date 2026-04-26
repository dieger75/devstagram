<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Request $request, Post $post) // se añade el método store para manejar la lógica de almacenar un nuevo like en la base de datos. Este método recibe una instancia de Request y una instancia de Post (que se obtiene a través de la ruta con la sintaxis {post}).
    {
        $post->likes()->create([
            // se utiliza la relación likes() definida en el modelo Post para crear un nuevo like asociado al post correspondiente. Esto se hace con el método create(), pasando un arreglo con los datos del nuevo like. En este caso, se asigna el user_id del like al id del usuario autenticado que realiza la acción de dar like.
            'user_id' => $request->user()->id,
        ]);

        /******************************************************
         Esto es lo que Eloquent ejecuta internamente con el método create() para crear un nuevo like asociado al post. No hace falta pasar el post_id porque Eloquent lo añade automáticamente al crear el like a través de la relación likes() del modelo Post.:

        Like::create([
            'post_id' => $post->id,  // ← lo añade solo
            'user_id' => $request->user()->id,
        ]);

        ******************************************************/

        return back();
    }
}
