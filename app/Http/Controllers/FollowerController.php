<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Follower;
use App\Models\User;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        /*
        Usando MODELO

        Follower::create([
            'user_id'     => $user->id,
            'follower_id' => auth()->user()->id
        ]);
        */

        // USANDO attach()
        $user->followers()->attach( auth()->user()->id );
        /**
         * El metodo recibe el $user del muro que se visita, esto es a travez de Route
         * followers()  -> gestiona la relacion de las tablas "users" y " followers"
         * attach() -> hace la query para insertar el registro con los campos de: usuario autenticado y el usuario del muro (como padre del método). Pasa el ultimo de dato de forma invisible
         */

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id );
        return back();
    }
}
