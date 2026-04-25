<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompraRequest;
use Illuminate\Http\Request;



class compraController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-compra|crear-compra|editar-compra|eliminar-compra',['only' => ['index']]);
        $this->middleware('permission:crear-compra',['only' => ['create','store']]);
        $this->middleware('permission:mostrar-compra',['only' => ['show']]);
        $this->middleware('permission:eliminar-compra',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante','proveedore.persona')
        ->where('estado',1)
        ->latest()
        ->get();

        return view('compra.index',compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        $proveedores = Proveedore::whereHas('persona', function($query){
            $query->where('estado', 1);
        })->get();
     
        $comprobantes = Comprobante::all();
        $productos    = Producto::where('estado', 1)->get();
     
        $prefijo = 'B001';
     
        
        $ultima = Compra::where('numero_comprobante', 'like', $prefijo . '-%')
                        ->orderByDesc('numero_comprobante')
                        ->value('numero_comprobante');
        
     
        if ($ultima) {
            
            $numero = (int) explode('-', $ultima)[1] + 1;
        } else {
            $numero = 1;
        }
     
        
        $siguienteComprobante = $prefijo . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
     
        return view('compra.create', compact(
            'proveedores',
            'comprobantes',
            'productos',
            'siguienteComprobante'   
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {   
        try{
            DB::beginTransaction();
            //llenar tabla compras
            $compra = Compra::create($request->validated());

            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
             //2.Realizar el llenado
            $siseArray = count($arrayProducto_id);
            $cont = 0; 
            while($cont < $siseArray) {
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_compra' => $arrayPrecioCompra[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont]
                    ]
                ]);
                //actualizar el stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);

                DB::table('productos')
                ->where('id', $producto->id)
                ->update([
                    'stock' => $stockActual + $stockNuevo
                ]);

                $cont++;
            }


                DB::commit();
            }catch(Exception $e){
                DB::rollBack();
            }
        return redirect()->route('compras.index')->with('success','Compra exitosa');
    }


    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        return view ('compra.show',compact('compra'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Compra::where('id',$id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('compras.index')->with('success','Compra eliminada');
    }
}
