<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('profile.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $profile)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $profile->id,
                'password' => 'nullable'
            ]);

            $passwordChanged = !empty($request->password);

            // Comprobar el password y aplicar el Hash
            if (empty($request->password)) {
                $request = Arr::except($request, array('password'));
            } else {
                $fieldHash = Hash::make($request->password);
                $request->merge(['password' => $fieldHash]);
            }

            $profile->update($request->all());

            Log::info('Perfil actualizado', [
                'user_id' => $profile->id,
                'email' => $profile->email,
                'name' => $profile->name,
                'password_changed' => $passwordChanged,
                'updated_by' => auth()->id(),
            ]);

            return redirect()->route('profile.index')->with('success', 'Cambios guardados');
        } catch (Exception $e) {
            Log::error('Error al actualizar perfil', [
                'message' => $e->getMessage(),
                'user_id' => $profile->id,
                'updated_by' => auth()->id(),
            ]);

            throw $e;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
