<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout()
    {
        $user = Auth::user();

        Log::info('Cierre de sesion', [
            'user_id' => $user?->id,
            'email' => $user?->email,
            'ip' => request()->ip(),
        ]);

        Auth::logout();
        Session::flush();

        return redirect()->route('login');
    }
}
