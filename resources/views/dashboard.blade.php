@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img
                    src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                    {{-- Si el usuario tiene una imagen de perfil, se muestra esa imagen utilizando la función asset() para generar la URL correcta. Si el usuario no tiene una imagen de perfil, se muestra una imagen predeterminada (usuario.svg) ubicada en la carpeta img. --}}
                    alt="Usuario"
                />
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center justify-center md:items-start py-10 md:py-10">
                {{--
                se recibe el usuario inyectado en el metodo index del controlador PostController
                {{dd($user)}} devuelve el objeto del usuario
                --}}
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if($user->id === auth()->user()->id)
                            <a
                                href="{{ route('perfil.index')}}" {{-- se añade un enlace al perfil del usuario autenticado utilizando la función route() para generar la URL de la ruta perfil.index --}}
                                class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{ $user->followers->count() }}
                    <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followings->count() }}
                    <span class="font-normal"> Siguiendo</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }}
                    <span class="font-normal"> Post</span>
                </p>

                @auth
                    @if( $user->id !== auth()->user()->id )
                        @if(!$user->siguiendo( auth()->user() ))
                        {{-- el usuario que visitamos, llama al metodo siguiendo() y le pasa el usario autenticado para comprobrar si ese mismo ya le está siguiendo --}}
                            <form
                                action="{{ route('users.follow', $user) }}"
                                {{-- se le pasa el user al que estamos visitando u perfil y no es el usuario autenticado --}}
                                method="POST"
                            >
                                @csrf
                                <input
                                    type="submit"
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Seguir"
                                />
                            </form>
                        @else
                            <form
                                action="{{ route('users.unfollow', $user) }}"
                                method="POST"
                                >
                                @csrf
                                @method('DELETE')

                                <input
                                type="submit"
                                class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                value="Dejar de Seguir"
                                />
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        {{-- Componente foreach--}}
        <x-listar-post :posts="$posts" />

    </section>
@endsection
