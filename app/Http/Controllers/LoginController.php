<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('panel');
        }
        return view('auth.login');
    }

    public function login(loginRequest $request){
        //validar credenciales
        if(!Auth::validate($request->only('email','password'))){
            Log::warning('Intento de inicio de sesion fallido', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->to('login')->withErrors('Credenciales incorrectas');
        }
        Log::info('Inicio de sesion exitoso', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);
        //crear una sesion
        $user = Auth::getProvider()->retrieveByCredentials($request->only('email','password'));
        Auth::login($user);

        return redirect()->route('panel')->with('success','Bienvenido '.$user->name);
    }
}