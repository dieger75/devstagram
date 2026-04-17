@extends('layouts.app')

@section('titulo')
    Crea una nueva publiación
@endsection

{{--
Se utiliza la directiva @push para agregar estilos específicos a esta vista, en este caso, el CSS de Dropzone
gracias a la directiva @stack('styles') que se encuentra en el head de la plantilla principal, los estilos agregados con @push('styles') se insertarán en ese lugar.
--}}
@push('style')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush


@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            {{-- Dropzone es una biblioteca de JavaScript que facilita la implementación de áreas de arrastrar y soltar para cargar archivos. En este caso, se está utilizando para permitir a los usuarios subir imágenes de manera intuitiva.
            El formulario tiene el atributo enctype="multipart/form-data", lo que indica que se pueden enviar archivos a través de este formulario. La clase dropzone se utiliza para aplicar los estilos de Dropzone, y el ID dropzone se utiliza para inicializar la funcionalidad de Dropzone en este formulario. Cuando los usuarios arrastran y sueltan archivos en esta área o hacen clic para seleccionar archivos, Dropzone manejará la carga de esos archivos al servidor. El actión del formulario apunta a la ruta imágenes.store, que viene del archivo de rutas web.php, y se espera que esta ruta maneje la lógica para almacenar las imágenes subidas.
            --}}
            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center bg-white">
                @csrf
            </form>
        </div>
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST" novalidate>
                {{-- Directiva para proteger el formulario contra ataques de tipo CSRF (Cross-Site Request Forgery) --}}
                @csrf
                <div class="mb-5">
                    <labe for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Título
                    </labe>
                    <input
                        id="titulo"
                        name="titulo"
                        type="text"
                        placeholder="Título de la Publicación"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{ old('titulo')}}" {{-- Se utiliza old('titulo') para mantener el valor del campo en caso de que haya un error de validación y el formulario se vuelva a mostrar. --}}
                    />
                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <labe for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </labe>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        type="text"
                        placeholder="Descripción de la publicación"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                    >{{ old('descripcion')}}</textarea>
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    {{-- Se utiliza un campo oculto para almacenar el nombre de la imagen que se ha subido a través de Dropzone. Este campo se llenará automáticamente con el nombre de la imagen una vez que se haya cargado exitosamente, gracias al código JavaScript que se encuentra en app.js. --}}
                    <input
                        name="imagen"
                        type="hidden"
                        value="{{ old('imagen') }}" {{-- Se utiliza old('imagen') para mantener el valor del campo en caso de que haya un error de validación y el formulario se vuelva a mostrar. --}}
                    />
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <input
                    type="submit"
                    value="Crear Publicación"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
