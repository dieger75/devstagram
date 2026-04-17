<?php
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
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

Route::get('/', function () {
    return view('principal');
});

// En vez de usar una función anónima, se puede usar un controlador para manejar la lógica de la ruta
// se añade la sintaxis fecha para asigna un nombre a la ruta
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// {user} es un parámetro que devolverá la informacion del usuario, pero por defecto devuelve el id del usuario.
// {user:username} con esta sintaxis se le indica a Laravel que en vez de buscar por id, busque por el campo username y devuelva el nombre del usuario. Esto permitirá pasar el usuario al metodo "index" del controlador PostController y mostrar su información en la vista del dashboard
Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index');

// se usa /post/create por la convención de REST para indicar que se va a crear un nuevo recurso (post)
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');
