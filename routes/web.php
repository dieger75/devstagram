<?php
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home'); // llama a un metodo __invoke()

// En vez de usar una función anónima, se puede usar un controlador para manejar la lógica de la ruta
// se añade la sintaxis fecha para asigna un nombre a la ruta
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// se usa /post/create por la convención de REST para indicar que se va a crear un nuevo recurso (post)
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// se añade la ruta para almacenar un nuevo post, utilizando el método POST para enviar la información del formulario de creación de post al método store del controlador PostController. Esto permitirá guardar la información del nuevo post en la base de datos.

Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// se añade la ruta para eliminar un post específico, utilizando la sintaxis {post} para pasar el id del post al método destroy del controlador PostController. Esto permitirá eliminar un post específico de la base de datos.

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Likes a los posts
Route::post('post/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store'); // se añade la ruta para almacenar un nuevo like en un post específico, utilizando la sintaxis {post} para pasar el id del post al método store del controlador LikeController. Esto permitirá asociar cada like con el post correspondiente y almacenarlo en la base de datos.

Route::delete('post/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');



/**************************************************************************
 * La regla general es: las rutas más específicas (fijas) van arriba, las más genéricas (con parámetros variables) van abajo. Los parámetros como {user} son "comodines" que atraparían cualquier segmento de URL si se evalúan primero. El riesgo real está cuando la ruta empieza directamente con el parámetro variable
 * Regla práctica: si tu ruta empieza con /{parametro}, va abajo. Si tiene al menos un segmento fijo al inicio como post/{id}/likes, puede ir en cualquier posición sin conflicto.
 *************************************************************************/


Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index');
// {user} es un parámetro que devolverá la informacion del usuario, pero por defecto devuelve el id del usuario.
// {user:username} con esta sintaxis se le indica a Laravel que en vez de buscar por id, busque por el campo username y devuelva el nombre del usuario. Esto permitirá pasar el usuario al metodo "index" del controlador PostController y mostrar su información en la vista del dashboard

Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // se añade la ruta para mostrar un post individual, utilizando la sintaxis {post} para pasar el id del post al método show del controlador PostController. Esto permitirá mostrar la información de un post específico en una vista dedicada para ese post.

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store'); // se añade la ruta para almacenar un nuevo comentario en un post específico, utilizando la sintaxis {post} para pasar el id del post al método store del controlador ComentarioController. Esto permitirá asociar cada comentario con el post correspondiente y almacenarlo en la base de datos.


// Siguiendo a usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');
