<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return response()->json( ['imagen' => $imagen->extension()] ); // se devuelve un JSON con la extensión del archivo subido, accediendo a ella con el método extension() del objeto $imagen
    }
}
