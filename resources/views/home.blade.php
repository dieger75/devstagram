{{-- Directiva para extender una plantilla
el nombre de la plantilla es el mismo que el del archivo sin la extension .blade.php - y con los puntos en lugar de las barras [carpeta.archivo] --}}

@extends('layouts.app')

{{-- Directiva para definir una seccion de contenido que se va a inyectar en la plantilla extendida --}}

@section('titulo')
    Página Principal
@endsection

@section('contenido')

    {{-- COMPONENTES CON SLOTS --}}
    {{-- Se puede dar un nombre al slot, en este caso titulo --}}
    {{-- <x-listar-post>
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando post desde slot</h1>
    </x-listar-post>
    --}}

    <x-listar-post :posts="$posts" />


@endsection
