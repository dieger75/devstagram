<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ImagenController extends Controller
{
    /**
     * Esta función recoge todos los datos que llegan de un formulario o petición HTTP y los devuelve como JSON.
     * Es una forma rápida de depurar y ver qué datos está recibiendo el servidor antes de procesarlos. Como un dd() pero en JSON.
     *
     * Request es la clase de Laravel que representa la petición HTTP. Se importa al principio del controlador:
     * $request — es el objeto que contiene todo lo que el usuario envía (campos de formulario, archivos, headers...). Laravel lo inyecta automáticamente.
     * $request->all() — coge todos esos datos como array.
     * response()->json() — los devuelve en formato JSON.
     *
     * El resultado se puede ver en la pestaña de red (network) de las herramientas de desarrollo del navegador, marcando Fetch/XHR para filtrar solo las peticiones AJAX, clicando en la petición a /imagenes y luego en la pestaña de respuesta (response) para ver el JSON que devuelve el servidor:
     *
     * {"_token":"RSYMJMpagyqGXaixfCNoN19osgd8Fz0s0ts7ny6e","file":{}}
     *
     * */

    public function store(Request $request)
    {
        //$input = $request->all();
        //return response()->json($input);

        $imagen = $request->file('file'); // con el método file() se accede al archivo que se ha subido, en este caso con el nombre 'file' que es el que se le da al campo de archivo en el formulario de la vista create.blade.php

        // return response()->json( ['imagen' => $imagen->extension()] );
        // se devuelve un JSON con la extensión del archivo subido, accediendo a ella con el método extension() del objeto $imagen

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); // se genera un nombre único para la imagen usando Str::uuid() que crea un UUID, y se le añade la extensión del archivo subido con el método extension() del objeto $imagen. Esto es para evitar que se sobrescriban archivos con el mismo nombre.

        $imageServidor = Image::make($imagen); // se crea una instancia de la clase Image de Intervention con el archivo subido, para poder manipularlo (redimensionar, recortar, etc.) antes de guardarlo en el servidor. Se le pasa el objeto $imagen que representa el archivo subido.

        $imageServidor->fit(1000, 1000); // se redimensiona la imagen a un tamaño de 1000x1000 (ancho, alto) píxeles usando el método fit() de la clase Image. Esto es para estandarizar el tamaño de las imágenes que se guardan en el servidor y evitar que sean demasiado grandes o pequeñas.

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; // se define la ruta completa donde se va a guardar la imagen en el servidor, usando la función public_path() de Laravel para obtener la ruta del directorio public y añadiendo la carpeta uploads y el nombre de la imagen generado anteriormente.

        // Crea la carpeta 'Uploads' si no existe, porque si no existe, al intentar guardar la imagen con el método save() de la clase Image, se producirá un error porque no se puede guardar en una carpeta que no existe. Por eso se verifica si la carpeta 'uploads' existe con File::exists() y si no existe, se crea con File::makeDirectory() con permisos 0755 y recursividad true para crear también subcarpetas si es necesario.
        if (!File::exists(public_path('uploads'))) {
            File::makeDirectory(public_path('uploads'), 0755, true);
        }

        $imageServidor->save($imagenPath); // se guarda la imagen redimensionada en el servidor usando el método save() de la clase Image, pasando la ruta completa donde se va a guardar la imagen.

        return response()->json( ['imagen' => $nombreImagen] ); // se devuelve un JSON con el nombre completo de la imagen, que es un UUID generado con Str::uuid() seguido de un punto y la extensión del archivo subido, accediendo a ella con el método extension() del objeto $imagen. Revisarlo en la consola del navegador.
    }
}
