<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
        //relacion entre el modelo Comentario y el modelo User, indicando que un comentario pertenece a un usuario. Esto se hace con el método belongsTo() de Eloquent, pasando como argumento el nombre del modelo relacionado (User::class). Esto permitirá acceder al usuario de un comentario a través de la propiedad $comentario->user en cualquier parte de la aplicación.
    }
}
