<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PerfilController extends Controller
{
    public function __construct()
    {
        // se añade el constructor para aplicar el middleware de autenticación a todas las rutas del controlador. De esta manera, se protege el acceso a las rutas relacionadas con el perfil, asegurando que solo los usuarios autenticados puedan acceder a ellas. Esto es importante para proteger la información del perfil de los usuarios y evitar que personas no autorizadas puedan acceder a ella.
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }
    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);
        // Antes de validar y guardar, se "limpia" el username para garantizar que siempre sea un valor seguro y compatible con URLs, independientemente de lo que el usuario haya escrito en el formulario.

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id, 'min:3','max:30', 'not_in:twitter,editar-perfil'],

            // cunado son más de 3 reglas de validación, se prefiere escribirlas en un array para mayor claridad, aunque también se podría escribir como 'required|unique:users|min:3|max:30'

            // La regla unique:users,username.'.auth()->user()->id es una forma de decir "el username debe ser único en la tabla users, pero ignora el registro del usuario actual (identificado por auth()->user()->id)". Esto es necesario para permitir que el usuario mantenga su username actual sin que la validación falle por considerar que ya existe en la base de datos.

            // La regla not_in:twitter,editar-perfil se añade para evitar que los usuarios puedan elegir usernames que entren en conflicto con rutas fijas de la aplicación, como /twitter o /editar-perfil, lo que podría causar problemas de enrutamiento y seguridad.
        ]);

        if($request->imagen){
            // Eliminar imagen anterior si existe
            $imagenAnterior = public_path('perfiles') . '/' . auth()->user()->imagen;
            if(File::exists($imagenAnterior)){
                File::delete($imagenAnterior);
            }
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imageServidor = Image::make($imagen);
            $imageServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imageServidor->save($imagenPath);

        }

        /** Guardar cambios */

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        // Si se ha subido una nueva imagen, se asigna su nombre a $usuario->imagen. Si no se ha subido una nueva imagen, se mantiene la imagen actual del usuario (auth()->user()->imagen). Si el usuario no tiene una imagen actual, se asigna null.
        $usuario->save();

        // Redireccionar
        return redirect()->route('post.index', $usuario->username);

    }
}
