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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            //Para follower_id → Laravel intentaría buscar una tabla llamada followers, que no existe. Por eso hay que decirle explícitamente en constrained() que también referencia a la tabla 'users'.
            //Ambas columnas son foreign keys hacia la misma tabla users, solo que con nombres semánticos distintos para distinguir roles (el seguido vs el seguidor).
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
        Schema::dropIfExists('followers');
    }
};
