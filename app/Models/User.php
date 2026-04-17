<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use HasApiTokens — el trait HasApiTokens permite usar Laravel Sanctum para autenticar usuarios a través de tokens API, lo que es útil para aplicaciones que necesitan autenticación sin estado (stateless) como APIs RESTful.
    // use Notifiable — el trait Notifiable permite enviar notificaciones a los usuarios, como correos electrónicos o notificaciones en la aplicación, utilizando el sistema de notificaciones de Laravel.
    // use HasFactory — el trait HasFactory permite usar factories para generar datos de prueba (útil para seeders y tests).

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Los datos que esperamos el usuario nos de al momento de registrarse, es decir, los datos que se pueden llenar masivamente
    // protected $fillable es un arreglo que contiene los nombres de los campos que se pueden llenar masivamente, es decir, los campos que se pueden asignar en masa al crear o actualizar un modelo (base de datos). Esto es una medida de seguridad para evitar la asignación masiva de campos no deseados.
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * RELACIONES ENTRE MODELOS
     */
    public function posts()
    {
        return $this->hasMany(Post::class); // se define la relación entre el modelo User y el modelo Post, indicando que un usuario puede tener muchos posts. Esto se hace con el método hasMany() de Eloquent, pasando como argumento el nombre del modelo relacionado (Post::class). Esto permitirá acceder a los posts de un usuario a través de la propiedad $user->posts en cualquier parte de la aplicación.
    }
}
