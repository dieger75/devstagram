{{-- Directiva para extender una plantilla
el nombre de la plantilla es el mismo que el del archivo sin la extension .blade.php - y con los puntos en lugar de las barras [carpeta.archivo] --}}

@extends('layouts.app')

{{-- Directiva para definir una seccion de contenido que se va a inyectar en la plantilla extendida --}}

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    <p>Contenido de la página principal</p>
@endsection
