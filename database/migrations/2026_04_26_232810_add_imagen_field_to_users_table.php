<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) { // se usa Schema::table en lugar de Schema::create porque solo se quiere modificar la tabla users existente, no crear una nueva tabla.
            $table->string('imagen')->nullable();
            // se añade la columna imagen a la tabla users para almacenar el nombre de la imagen de perfil de cada usuario.
            // Se establece como nullable porque no todos los usuarios tendrán una imagen de perfil, por lo que se permite que este campo pueda ser nulo en la base de datos.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('imagen'); // se añade la función dropColumn para eliminar la columna imagen de la tabla users en caso de que se quiera revertir la migración.

        });
    }
};
