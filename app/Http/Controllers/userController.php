<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;

class UserController extends Controller
{
    function __construct()
   {
        $this->middleware('permission:ver-user|crear-user|editar-user|eliminar-user',['only' => ['index']]);
        $this->middleware('permission:crear-user',['only' => ['create','store']]);
        $this->middleware('permission:editar-user',['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-user',['only' => ['destroy']]);
    }
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
            
            $fieldHash = Hash::make($request->password);
            
            $request->merge(['password' => $fieldHash]);
            
            $user = User::create($request->all());
           
            $user->assignRole($request->role);

            DB::commit();

            Log::info('Usuario registrado', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $request->role,
                'created_by' => auth()->id(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al registrar usuario', [
                'message' => $e->getMessage(),
                'email' => $request->email,
                'role' => $request->role,
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->route('users.index')->with('success','Usuario Registrado');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try{
            DB::beginTransaction();
            //Comprobar el password y aplicar el Hash
            if (empty($request->password)) {
                $request = Arr::except($request, array('password'));
            } else {
                $fieldHash = Hash::make($request->password);
                $request->merge(['password' => $fieldHash]);
            }
            
            $user->update($request->all());

            //Actualizar el rol
            $user->syncRoles([$request->role]);
    
            DB::commit();

            Log::info('Usuario editado', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $request->role,
                'updated_by' => auth()->id(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error al editar usuario', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
                'email' => $request->email,
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario editado');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            Log::warning('Intento de eliminar usuario no encontrado', [
                'user_id' => $id,
                'deleted_by' => auth()->id(),
            ]);

            return redirect()->route('users.index')->with('error', 'Usuario no encontrado');
        }

        //Eliminar rol
        $rolUser = $user->getRoleNames()->first();
        $user->removeRole($rolUser);

        //Eliminar usuario
        $user->delete();

        Log::info('Usuario eliminado', [
            'user_id' => $user->id,
            'email' => $user->email,
            'deleted_by' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario eliminado');
         
    }
}
