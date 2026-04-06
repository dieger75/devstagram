<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request->get('username'));

        // Validación de datos
        $this->validate($request, [
            //'name' => ['required', 'min:5'], esta es otra forma de escribir la validación, pero se prefiere la forma de abajo
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);




    }
}
