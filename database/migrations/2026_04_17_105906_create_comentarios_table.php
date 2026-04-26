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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // se añade la columna user_id como clave foránea que hace referencia a la tabla users, lo que permitirá relacionar cada comentario con un usuario específico. Esto se hace utilizando el método foreignId() para crear la columna y el método constrained() para establecer la relación con la tabla users.
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('comentario'); // se añade la columna comentario para almacenar el texto del comentario, utilizando el tipo de dato string para permitir almacenar texto de longitud variable.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};
