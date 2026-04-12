@extends('layouts.app')

@section('titulo')
    Inicia sesión en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
           <img src="{{ asset('img/login.jpg') }}" alt="Imagen login de usuarios" class="rounded-lg">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            {{-- El atributo novalidate se utiliza para deshabilitar la validacion del navegador y permitir que laravel maneje la validacion de los campos del formulario --}}
            <form action="{{ route('login') }}" method="POST" novalidate>
                {{-- Directiva para proteger el formulario contra ataques de tipo CSRF (Cross-Site Request Forgery) --}}
                @csrf

                {{--
                session('mensaje') lee ese valor flasheado. Si existe, muestra el párrafo; si no, no muestra nada.
                De dónde sale session() — es un helper global de Laravel que accede al sistema de sesiones. No tienes que importar nada. Laravel gestiona la sesión automáticamente via cookie.
                --}}
                @if(session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif

                <div class="mb-5">
                    <labe for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </labe>
                    <input
                        for="email"
                        name="email"
                        type="email"
                        placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email')}}"
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <labe for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </labe>
                    <input
                        for="password"
                        name="password"
                        type="password"
                        placeholder="Password de registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5 ">
                    <input type="checkbox" name="remember" id=""> <label class="text-gray-500 text-sm">Mantener mi sesión abierta</label>
                </div>

                <input
                    type="submit"
                    value="Iniciar sesión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
