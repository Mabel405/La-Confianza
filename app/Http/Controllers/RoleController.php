<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-role|crear-role|editar-role|eliminar-role',['only' => ['index']]);
        $this->middleware('permission:crear-role',['only' => ['create','store']]);
        $this->middleware('permission:editar-role',['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-role',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create',compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);
    
        try {
            DB::beginTransaction();
    
            // crear rol
            $rol = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
    
            // convertir IDs en nombres de permisos
            $permisos = Permission::whereIn('id', $request->permission)
                            ->pluck('name')
                            ->toArray();
    
            // asignar permisos
            $rol->syncPermissions($permisos);
    
            DB::commit();
    
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    
        return redirect()->route('roles.index')->with('success','Rol registrado');
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
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit', compact('role','permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name, '.$role->id,
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();
            //Actualizar rol

            Role::where('id', $role->id)
            ->update([
                'name' => $request->name
            ]);
            //Actualizar permisos
            $role->syncPermissions($request->permission);

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();

        }

        return  redirect()->route('roles.index')->with('success','rol editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id',$id)->delete();
        return redirect()->route('roles.index')->with('success','Rol eliminado');
    }
}
