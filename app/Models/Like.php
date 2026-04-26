<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [ // protected $fillable es un arreglo que contiene los nombres de los campos que se pueden llenar masivamente, es decir, los campos que se pueden asignar en masa al crear o actualizar un modelo (base de datos). Esto es una medida de seguridad para evitar la asignación masiva de campos no deseados.
        'user_id',
        'post_id'
    ];
}
