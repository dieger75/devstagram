{{-- Directiva para extender una plantilla
el nombre de la plantilla es el mismo que el del archivo sin la extension .blade.php - y con los puntos en lugar de las barras [carpeta.archivo] --}}

@extends('layouts.app')

{{-- Directiva para definir una seccion de contenido que se va a inyectar en la plantilla extendida --}}

@section('titulo')
    Página Principal
@endsection

@section('contenido')

    @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($posts as $post)
                <div class="mb-10">
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user])}}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-center">No hay Posts, sigue a alguien para poder mostrar sus posts</p>
    @endif


@endsection
