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
        Schema::table('users', function (Blueprint $table) {
            // se añade el campo username a la tabla users, se indica que es único y se coloca después del campo name, este archvio controla las versiones de la base de datos, se ejecuta con el comando php artisan migrate
            $table->string('username');
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
            // se elimina el campo username de la tabla users
            $table->dropColumn('username');
        });
    }
};
