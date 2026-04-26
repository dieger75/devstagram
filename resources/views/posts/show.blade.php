@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection


@section('contenido')

    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}" alt="">
            <div class="p-3 flex items-center gap-4">
                @auth
                    @if($post->checkLike( auth()->user() ))
                        <p>Este usuario ya dio like</p>
                    @else
                        <form method="POST" action="{{ route('posts.likes.store', $post)}}">
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif
                @endauth
                <p>0 Likes</p>
            </div>

            <div>
                <p class="font-bold">{{ $post->user->name }}</p>
                <p class="text-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="mt-5">
                    {{ $post->descripcion }}
                </p>
            </div>
            {{-- se utiliza la directiva @auth para mostrar el formulario de eliminación del post solo a los usuarios autenticados, lo que garantiza que solo los usuarios registrados puedan eliminar sus propios posts. --}}
            @auth
                @if ($post->user_id === auth()->user()->id)
                {{-- se verifica si el usuario autenticado es el autor del post utilizando la relacion de los modelos, lo que permite mostrar el formulario de eliminación solo al autor del post. Esto se hace comparando el user_id del post (Model Post) con el id del usuario (Model User) autenticado (auth()->user()->id), lo que garantiza que solo el autor del post pueda eliminarlo. --}}
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE') {{-- Se le conoce como METHOD SPOOFING. Como el navegador solo soporta métodos GET y POST, este método permite simular otros métodos como DELETE, PATCH, PUT --}}
                        @csrf
                        <input
                            type="submit"
                            value="Eliminar Publicación"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer"
                        />
                    </form>
                @endif
            @endauth
        </div>
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">
                @auth {{-- se utiliza la directiva @auth para mostrar el formulario de comentarios solo a los usuarios autenticados, lo que garantiza que solo los usuarios registrados puedan agregar comentarios a los posts. --}}
                    <p class="text-xl font-bold text-center mb-4">Agraga un nuevo comentario</p>

                    {{-- se muestra un mensaje de éxito utilizando session('mensaje') después de agregar un nuevo comentario, lo que proporciona retroalimentación al usuario sobre la acción realizada. --}}
                    @if (session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post,'user' => $post->user ]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <labe for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Añade un comentario
                            </labe>
                            <textarea
                            id="comentario"
                            name="comentario"
                            type="text"
                            placeholder="Agrega un Comentario"
                            class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                            ></textarea>
                            @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <input
                        type="submit"
                        value="Comentar"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                        />
                    </form>
                @endauth

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count()) {{-- se verifica si el post tiene comentarios utilizando $post->comentarios->count(), lo que permite mostrar los comentarios existentes o un mensaje indicando que no hay comentarios aún. --}}
                        @foreach ($post->comentarios as $comentario) {{-- se itera sobre los comentarios del post utilizando un bucle @foreach, usando la variable "$comentario" (puede ser cualquier otra) lo que permite mostrar cada comentario asociado al post en la vista. --}}

                            <div class="p-5 boder-gray-300 border-b">

                                <a href="{{ route('post.index', $comentario->user) }}" class="font-bold"> {{-- se usa el modelo index() de PostController que es el que muestra el muro de un usuario específico, pasando como parámetro el usuario asociado al comentario ($comentario->user) --}}


                                    {{ $comentario->user->username }} {{-- se muestra el nombre de usuario del autor del comentario accediendo a través de la relación definida en el modelo Comentario, utilizando $comentario->user->username para mostrar el nombre de usuario del autor del comentario. --}}
                                </a>

                                <p>{{ $comentario->comentario}}</p> {{-- se muestra el contenido del comentario accediendo a la columna "comentario" de la tabla de comentarios --}}

                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p> {{-- se muestra la fecha de creación del comentario utilizando $comentario->created_at->diffForHumans() --}}
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios aún.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>



@endsection
