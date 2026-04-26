@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ asset('img/usuario.svg') }}" alt="Usuario">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center justify-center md:items-start py-10 md:py-10">
                {{--
                se recibe el usuario inyectado en el metodo index del controlador PostController
                {{dd($user)}} devuelve el objeto del usuario
                --}}
                <p class="text-gray-700 text-2xl mb-5">{{ $user->username }}</p>

                <p class="text-gray-800 text-sm font-bold">
                    0
                    <span class="font-normal"> Seguidores</span>
                </p>
                <p class="text-gray-800 text-sm font-bold">
                    0
                    <span class="font-normal"> Siguiendo</span>
                </p>
                <p class="text-gray-800 text-sm font-bold">
                    0
                    <span class="font-normal"> Post</span>
                </p>
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        @if ($posts->count()) {{-- se verifica si hay posts para mostrar, utilizando el método count() para contar el número de posts obtenidos --}}

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($posts as $post)
                    <div class="mb-10">
                        <a href="{{ route('posts.show', ['post' => $post, 'user' => $user])}}"> {{-- se añade un enlace a cada imagen del post utilizando la función route() para generar la URL de la ruta posts.show, pasando el objeto $post como parámetro para mostrar la información del post específico en la vista dedicada para ese post. Por defecto si no se le pasa paningún parámetro, muestra el ID del post --}}
                            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="my-10">
                {{ $posts->links() }} {{-- se muestra la paginación de los posts utilizando el método links() para generar los enlaces de paginación, previamente en PostController hay que llamar al método paginate() --}}

            </div>
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-bold">No hay publicaciones</p>
        @endif

    </section>
@endsection
