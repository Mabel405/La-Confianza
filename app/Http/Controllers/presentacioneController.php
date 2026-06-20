<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresentacioneRequest;
use App\Http\Requests\UpdatePresentacioneRequest; 
use App\Models\Caracteristica;
use App\Models\Presentacione; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class presentacioneController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-presentacione|crear-presentacione|editar-presentacione|eliminar-presentacione',['only' => ['index']]);
        $this->middleware('permission:crear-presentacione',['only' => ['create','store']]);
        $this->middleware('permission:editar-presentacione',['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-presentacione',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->get();

        return view('presentacione.index',['presentaciones' =>$presentaciones]);
    }
        //
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacione.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacioneRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('presentaciones.index')->with('success','Presentacion registrada');
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
    public function edit(Presentacione $presentacione)
    {
        return view('presentacione.edit',['presentacione'=>$presentacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacioneRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id',$presentacione->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success','Presentacion editada');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $presentacione = Presentacione::find($id);
        if ($presentacione->caracteristica->estado ==1){
            Caracteristica::where('id',$presentacione->caracteristica->id)
                ->update([
                    'estado'=> 0
                ]);
            $message = 'Presentacion eliminada';
        } else {
            Caracteristica::where('id',$presentacione->caracteristica->id)
                ->update([
                    'estado'=> 1
                ]);
            $message = 'Presentacion restaurada';
        }
        return redirect()->route('presentaciones.index')->with('success', $message);
        
    }
}
