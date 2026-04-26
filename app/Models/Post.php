<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * extends Model — hereda toda la funcionalidad de Eloquent ORM, lo que te permite hacer queries a la base de datos sin escribir SQL directamente.
 */
class Post extends Model
{
    use HasFactory;
    /** use HasFactory — el trait HasFactory permite usar factories para generar datos de prueba (útil para seeders y tests). */

    // protected $fillable es un arreglo que contiene los nombres de los campos que se pueden llenar masivamente, es decir, los campos que se pueden asignar en masa al crear o actualizar un modelo (base de datos). Esto es una medida de seguridad para evitar la asignación masiva de campos no deseados.
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    /**
     * RELACIONES ENTRE MODELOS
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('name', 'username'); // se define la relación entre el modelo Post y el modelo User, indicando que un post pertenece a un usuario. Esto se hace con el método belongsTo() de Eloquent, pasando como argumento el nombre del modelo relacionado (User::class). Esto permitirá acceder al usuario de un post a través de la propiedad $post->user en cualquier parte de la aplicación.
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
        // se define la relación entre el modelo Post y el modelo Comentario, indicando que un post puede tener muchos comentarios. Esto se hace con el método hasMany() de Eloquent, pasando como argumento el nombre del modelo relacionado (Comentario::class). Esto permitirá acceder a los comentarios de un post a través de la propiedad $post->comentarios en cualquier parte de la aplicación.
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
        // relacionamos tabla de Post con Like, ya que un post puede tener muchos likes hasMany()

    }

    // metodo para revisar si un usuario dio "me gusta" para evitar duplicados
    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
        // Con esto se posiciona en la tabla de "likes", utilizando contains() se analizam si la tabla de "likes" CONTIENE, en su columna de user_id, el id del usuario autenticado o usuario que dio "me gusta".

    }
}
