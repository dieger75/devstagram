import Dropzone from "dropzone";

Dropzone.autoDiscover = false;


const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,
})

// Eventos de Dropzone

// El evento 'sending' se dispara cuando se está enviando un archivo al servidor. En este caso, se está registrando el objeto formData en la consola, que contiene los datos que se están enviando junto con el archivo. Esto puede ser útil para depurar y verificar qué datos se están enviando al servidor durante la carga del archivo.
dropzone.on('sending', function(file, xhr, formData) {
    console.log(formData);
});

// El evento 'success' se dispara cuando un archivo se ha cargado exitosamente al servidor. En este caso, se está registrando la respuesta del servidor en la consola. Esto puede ser útil para verificar que la carga del archivo se haya realizado correctamente y para ver cualquier información adicional que el servidor pueda haber devuelto en la respuesta.
dropzone.on('success', function (file, response) {
    console.log(response); //se obtiene la respuesta de lo que se haya declarado en la función store() del controlador ImagenController.
});

// El evento 'error' se dispara cuando ocurre un error durante la carga del archivo. En este caso, se está registrando el mensaje de error en la consola. Esto puede ser útil para identificar y solucionar problemas que puedan surgir durante la carga de archivos, como problemas de conexión, archivos no permitidos o errores del servidor.
dropzone.on('error', function (file, message) {
    console.log(message);
});

// El evento 'removedfile' se dispara cuando un archivo es eliminado de la zona de carga. En este caso, se está registrando un mensaje en la consola indicando que el archivo ha sido eliminado. Esto puede ser útil para realizar acciones adicionales cuando un archivo es removido, como actualizar la interfaz de usuario o realizar una solicitud al servidor para eliminar el archivo del almacenamiento.
dropzone.on('removedfile', function () {
    console.log('Archivo Eliminado');
});
