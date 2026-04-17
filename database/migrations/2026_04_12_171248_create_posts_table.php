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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('imagen');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // se crea una clave foránea que hace referencia al id del usuario en la tabla users, esto es para relacionar cada post con un usuario, y se añade onDelete('cascade') para que si se borra un usuario, se borren también sus posts relacionados en la tabla posts, esto es para mantener la integridad referencial de la base de datos y evitar que queden posts huérfanos sin un usuario asociado.
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
        Schema::dropIfExists('posts');
    }
};
