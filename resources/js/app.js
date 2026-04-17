import Dropzone from "dropzone";

Dropzone.autoDiscover = false;


const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada ={};
            imagenPublicada.size = 1234; // se asigna un tamaño ficticio a la imagen publicada para que Dropzone pueda mostrarla correctamente
            imagenPublicada.name = document.querySelector('[name="imagen"]').value; // se obtiene el valor del campo oculto que contiene el nombre de la imagen publicada

            this.options.addedfile.call(this, imagenPublicada); // se llama a la función addedfile de Dropzone para agregar la imagen publicada a la zona de carga. Se pasa el objeto imagenPublicada como argumento para que Dropzone pueda mostrar la imagen correctamente.
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`); // se llama a la función thumbnail de Dropzone para generar una miniatura de la imagen publicada. Se pasa el objeto imagenPublicada y la ruta de la imagen como argumentos para que Dropzone pueda mostrar la miniatura correctamente.

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete'); // se agregan las clases dz-success y dz-complete al elemento de vista previa de la imagen publicada para indicar que la imagen se ha cargado correctamente y se ha completado el proceso de carga. Esto puede ayudar a mejorar la apariencia visual de la zona de carga y proporcionar retroalimentación al usuario sobre el estado de la imagen publicada.
        }
    },
})

// Eventos de Dropzone

// El evento 'sending' se dispara cuando se está enviando un archivo al servidor. En este caso, se está registrando el objeto formData en la consola, que contiene los datos que se están enviando junto con el archivo. Esto puede ser útil para depurar y verificar qué datos se están enviando al servidor durante la carga del archivo.
dropzone.on('sending', function(file, xhr, formData) {
    console.log(formData);
});

// El evento 'success' se dispara cuando un archivo se ha cargado exitosamente al servidor. En este caso, se está registrando la respuesta del servidor en la consola. Esto puede ser útil para verificar que la carga del archivo se haya realizado correctamente y para ver cualquier información adicional que el servidor pueda haber devuelto en la respuesta.
dropzone.on('success', function (file, response) {
    console.log(response.imagen); //se obtiene la respuesta de lo que se haya declarado en la función store() del controlador ImagenController.

    document.querySelector('[name="imagen"]').value = response.imagen; //se asigna el valor de la imagen a un campo oculto en el formulario para que se pueda enviar junto con los demás datos del formulario.
});

// El evento 'error' se dispara cuando ocurre un error durante la carga del archivo. En este caso, se está registrando el mensaje de error en la consola. Esto puede ser útil para identificar y solucionar problemas que puedan surgir durante la carga de archivos, como problemas de conexión, archivos no permitidos o errores del servidor.
dropzone.on('error', function (file, message) {
    console.log(message);
});

// El evento 'removedfile' se dispara cuando un archivo es eliminado de la zona de carga. En este caso, se está registrando un mensaje en la consola indicando que el archivo ha sido eliminado. Esto puede ser útil para realizar acciones adicionales cuando un archivo es removido, como actualizar la interfaz de usuario o realizar una solicitud al servidor para eliminar el archivo del almacenamiento.
dropzone.on('removedfile', function () {
    //console.log('Archivo Eliminado');

    document.querySelector('[name="imagen"]').value = ''; // se borra el valor del campo oculto que contiene el nombre de la imagen cuando se elimina un archivo de la zona de carga. Esto asegura que si el usuario decide eliminar la imagen cargada, el campo oculto también se actualice para reflejar esa acción y no envíe un valor incorrecto al servidor.
});
