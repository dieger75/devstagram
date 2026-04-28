<div>
    @if ($posts->count()) {{-- se verifica si hay posts para mostrar, utilizando el método count() para contar el número de posts obtenidos --}}

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($posts as $post)
                    <div class="mb-10">
                        <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user])}}"> {{-- se añade un enlace a cada imagen del post utilizando la función route() para generar la URL de la ruta posts.show, pasando el objeto $post como parámetro para mostrar la información del post específico en la vista dedicada para ese post. Por defecto si no se le pasa paningún parámetro, muestra el ID del post --}}
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
</div>
