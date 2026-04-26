<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // el middleware('auth') se encarga de verificar si el usuario está autenticado, esto es necesario para proteger las rutas que requieren autenticación, en este caso, la ruta del muro donde se muestran los posts, ya que solo los usuarios autenticados pueden verlos

        // $this->middleware('auth');

        $this->middleware('auth')->except(['show', 'index']); // se añade el método except() para indicar que la ruta "show" y "index" no requieren autenticación, lo que permitirá a cualquier usuario ver un post específico o el muro de posts sin necesidad de estar autenticado. Esto es útil para permitir que los usuarios compartan sus posts con otros usuarios o para mostrar posts públicos sin requerir autenticación.
    }

    /**
     * Desde los Route:: en web.php  se le pasa el usuario al metodo "index" del controlador PostController, esto se hace con la sintaxis {user:username} en la ruta. Para ello debe añadirse aqui el model User como parametro con la variable identificativa del usuario $user
     */

    public function index(User $user)
    {   // dd($user); ---- informacion del usuario
        // dd($user->username);  ----- nombre del usuario
        // dd($user->id);  --- id del usuario


        // $posts = Post::where('user_id', $user->id)->get(); // se obtiene la información de los posts del usuario que se ha pasado como parámetro al método index, utilizando el modelo Post y el método where() para filtrar los posts por el user_id que coincide con el id del usuario pasado como parámetro. Luego se llama al método get() para obtener los resultados de la consulta.

        $posts = Post::where('user_id', $user->id)->paginate(20); // se obtiene la información de los posts del usuario que se ha pasado como parámetro al método index, utilizando el modelo Post y el método where() para filtrar los posts por el user_id que coincide con el id del usuario pasado como parámetro. Luego se llama al método paginate() para obtener los resultados de la consulta paginados, en este caso, mostrando 5 posts por página.

        //dd($posts); --- se muestra la información de los posts obtenidos para verificar que se han obtenido correctamente

        /*
        Se aprovecha la relación entre el modelo User y el modelo Post para obtener los posts del usuario de manera más sencilla, accediendo a la relación posts() definida en el modelo User. Esto se hace utilizando la sintaxis $user->posts, lo que devuelve una colección de los posts asociados al usuario. Esto es útil para simplificar el código y aprovechar las relaciones definidas entre los modelos. Pero no funciona con la paginación, por lo que se opta por la consulta directa utilizando el modelo Post y el método where() para filtrar los posts por el user_id.

        return view('dashboard', [
            'user' => $user
        ]);
        */

        /** Para paginacion */
        return view('dashboard', [
            'user' => $user, // se pasa el usuario a la vista del dashboard para mostrar su información en la vista (mirar la sintaxis de vista)
            'posts' => $posts // se pasa la información de los posts a la vista del dashboard para mostrar los posts del usuario en la vista
        ]);

    }

    public function create() // se muestra el formulario de creación de post, simplemente se devuelve la vista posts.create que contiene el formulario para crear un nuevo post.
    {
        return view('posts.create'); //
    }

    // se recibe la información del formulario de creación de post, se valida y se guarda en la base de datos
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        /* La forma más sencilla de guardar la información del post en la base de datos es utilizando el método create() del modelo Post, pasando un arreglo con los datos del post que se quieren guardar. Esto es útil para crear un nuevo post de manera rápida y concisa, siempre y cuando se hayan definido los campos fillable en el modelo para permitir la asignación masiva de esos campos.

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
            ]);

        */

        /** --------------------------- */

        /* Otra forma de guardar la información del post en la base de datos es creando una nueva instancia del modelo Post, asignando los valores a sus propiedades y luego llamando al método save() para guardar el post en la base de datos. Esto es útil si se necesita realizar alguna lógica adicional antes de guardar el post, como modificar los datos o realizar alguna acción relacionada con el usuario.

        $post = new Post();
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();

        */

        /** --------------------------- */

        /** Otra forma de guardar la información del post en la base de datos es utilizando la relación entre el modelo User y el modelo Post. Esto se hace accediendo al usuario autenticado a través del objeto Request, luego accediendo a su relación posts() y llamando al método create() para crear un nuevo post asociado a ese usuario. Esto es útil para aprovechar la relación definida entre los modelos y evitar tener que asignar manualmente el user_id al crear el post. Las relaciones simplifican el código y hacen que sea más fácil trabajar con los datos. */


        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('post.index', auth()->user()->username); // se redirige al usuario a su muro después de crear el post, pasando su nombre de usuario como parámetro para mostrar su información en la vista del dashboard
    }
    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }
    // se añade el método show() para mostrar un post específico, recibiendo como parámetros el usuario y el post, y pasando esa información a la vista posts.show para mostrar la información del post en una vista dedicada para ese post.

    public function destroy(Post $post)
    {
        // dd('Eliminando', $post->id);

        $this->authorize('delete', $post); // se utiliza el método authorize() para verificar si el usuario tiene permiso para eliminar el post, pasando como argumento la acción 'delete' y el post que se intenta eliminar. Esto es útil para proteger la ruta de eliminación de posts y asegurarse de que solo los usuarios autorizados puedan eliminar un post específico. Devuelve un error 403 si el usuario no tiene permiso para eliminar el post.

        $post->delete(); // metodo Eloquent delete() para eliminar el post de la base de datos. Eso es ejecutar la query de eliminación del registro en la base de datos. No confundir con el metodo delete de PostPolicy anteriormente definido.

        /** Eliminar imagen */
        $imagen_path = public_path('uploads/' . $post->imagen); // se obtiene la ruta completa de la imagen asociada al post que se va a eliminar, utilizando la función public_path() para obtener la ruta del directorio público y concatenando el nombre de la imagen almacenada en el campo 'imagen' del post.

        if(File::exists($imagen_path)) { // se verifica si la imagen existe en el servidor utilizando el método exists() de la clase File, pasando como argumento la ruta completa de la imagen. Esto es útil para evitar errores al intentar eliminar una imagen que no existe.

            unlink($imagen_path); // se elimina la imagen del servidor utilizando la función PHP unlink(), pasando como argumento la ruta completa de la imagen.
        }


        return redirect()->route('post.index', auth()->user()->username); // se redirige al usuario a su muro después de eliminar el post, pasando su nombre de usuario como parámetro para mostrar su información en la vista del dashboard

    }

}
