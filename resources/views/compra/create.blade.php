@extends('template')

@section('title','Crear compra')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
        <li class="breadcrumb-item active">Crear compras</li>
    </ol>
</div>

<form action="{{ route('compras.store') }}" method="post">
    @csrf

    <div class="container mt-4">
        <div class="row gy-4">

            <!-- Detalles de la compra -->
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la compra
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">

                        <!-- Producto -->
                        <div class="col-md-12 mb-4">
                            <select name="producto_id" id="producto_id"
                                class="form-control selectpicker"
                                data-live-search="true"
                                data-size="3"
                                title="Busque un producto aqui">
                                @foreach ($productos as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cantidad -->
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>

                        <!-- Precio compra -->
                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio de compra:</label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                        </div>

                        <!-- Precio venta -->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                        </div>

                        <!-- Botón agregar -->
                        <div class="col-md-12 mb-4 mt-2 text-end">
                            <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                        </div>

                        <!-- Tabla detalle -->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Suma</th>
                                            <th colspan="2"><span id="suma">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">IGV %</th>
                                            <th colspan="2"><span id="igv">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"> <input type="hidden" name="total" value="0" id="inputTotal"> <span id="total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Cancelar -->
                        <div class="col-md-12 mb-2">
                            <button id="cancelar" type="button" class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Cancelar compra
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Datos generales -->
            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>

                <div class="p-3 border border-3 border-success">
                    <div class="row">

                        <!-- Proveedore -->
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor:</label>
                            <select name="proveedore_id" id="proveedore_id"
                                class="form-control selectpicker show-tick"
                                data-live-search="true"
                                title="Selecciona"
                                data-size="3">
                                @foreach ($proveedores as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->persona->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error ('proveedore_id')
                                <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!-- Comprobante -->
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id"
                                class="form-control selectpicker show-tick"
                                title="Selecciona">
                                @foreach ($comprobantes as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->tipo_comprobante }}
                                    </option>
                                @endforeach
                            </select>
                            @error ('comprobante_id')
                                <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!-- Número comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">
                                Numero de comprobante:
                            </label>
                         
                            {{-- Campo visible (readonly, solo informativo) --}}
                            <input type="text"
                                   class="form-control border-success bg-light"
                                   value="{{ $siguienteComprobante }}"
                                   readonly>
                         
                            {{-- Campo oculto que se envía en el POST --}}
                            <input type="hidden"
                                   name="numero_comprobante"
                                   id="numero_comprobante"
                                   value="{{ $siguienteComprobante }}">
                         
                            @error('numero_comprobante')
                                <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!-- Impuesto -->
                        <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Impuesto:</label>
                            <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success">
                            @error ('impuesto')
                                <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha"
                                class="form-control border-success"
                                value="<?php echo date("Y-m-d")?>">
                            <?php
                            use Carbon\Carbon;
                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>

                        </div>

                        <!-- Guardar -->
                        <div class="col-md-12 mb-2 text-center">
                            <button type="submit" class="btn btn-success" id="guardar">
                                Guardar
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal cancelar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que quieres cancelar la compra?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btnCancelarCompra" type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn_agregar').click(function () {
            agregarProducto();
        });
        $('#btnCancelarCompra').click(function () {
            cancelarCompra();
        });
        disableButtons();
        $('#impuesto').val(impuesto + '%');
    });

    // Variables
    let cont = 0;
    let subtotal = [];
    let suma = 0;
    let igv = 0;
    let total = 0;

    // Constante
    const impuesto = 18;

    function cancelarCompra() {
        // eliminar el tbody de la tabla
        $('#tabla_detalle > tbody').empty();
        // añadir una nueva fila a la tabla
        let fila = '<tr>' +
            '<th></th>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>';
        $('#tabla_detalle').append(fila);
        // reiniciar valores
        cont = 0;
        subtotal = [];
        suma = 0;
        igv = 0;
        total = 0;
        // mostrar valores
        $('#suma').html(suma);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(impuesto + '%');
        $('#inputTotal').val(total);

        limpiarCampos();
        disableButtons();

    }
    // ya esta
    function disableButtons() {
        if (total == 0) {
            $('#guardar').hide();
            $('#cancelar').hide();
        } else {
            $('#guardar').show();
            $('#cancelar').show();
        }
    }
    function agregarProducto() {
        //obtener valores de los campos
        let idProducto = $('#producto_id').val();
        let nameProducto = ($('#producto_id option:selected').text());
        let cantidad = $('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let precioVenta = $('#precio_venta').val();

        //validaciones
        //1. Para que los campos no esten vacios //ya esta
        //if (nameProducto !=  && cantidad != && precioCompra != '' && precioVenta != '') {
        if (nameProducto != '' && cantidad != '' && precioCompra != '' && precioVenta != '') {

            if (
                (parseInt(cantidad) > 0 &&
                (cantidad % 1 == 0) && parseFloat(precioCompra)
                > 0 && parseFloat(precioVenta) > 0)
            ) {
                if (parseFloat(precioVenta) > parseFloat(precioCompra)) {
                    //calcular valores //ya esta
                    subtotal[cont] = round(cantidad * precioCompra);
                    suma += subtotal[cont];
                    igv = round(suma / 100 * impuesto);
                    total = round(suma + igv);
    
                    let fila = '<tr id="fila' + cont + '">' +
                        '<th>' + (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                        '<td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">' + precioCompra + '</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + precioVenta + '</td>' +
                        '<td>' + subtotal[cont] + '</td>' +
                        '<td><button class="btn btn-danger" type="button" onclick="eliminarProducto(' + cont + ')"><i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';
                    
                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;
                    disableButtons();
    
                    //mostrar los campos calculados
                    $('#suma').html(suma);
                    $('#igv').html(igv);
                    $('#total').html(total);
                    $('#impuesto').val(igv);
                    $('#inputTotal').val(total);
    
                } else {
                    showModal('Precio de compra incorrecto');
                }
            } else {
                showModal('Valores numéricos incorrectos');
            }
        } else {
            showModal('Le faltan campos por llenar');
        }
    }

    function eliminarProducto(indice) {
        //calcular valores
        suma -= round(subtotal[indice]);
        igv = round(suma / 100 * impuesto);
        total = round(suma + igv);
        // mostrar los campos calculados
        $('#suma').html(suma);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(igv);
        $('#inputTotal').val(total);
        // eliminar la fila de la tabla
        $('#fila' + indice).remove();

        disableButtons();
    }
    //ya esta
    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_compra').val('');
        $('#precio_venta').val('');
    }
    //ya esta
    function round(num, decimales = 2) {
        let signo = num >= 0 ? 1 : -1;
        num = num * signo;

        if (decimales === 0) return signo * Math.round(num);

        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        num = num.toString().split('e');

        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
    // ya esta
    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: icon,
            title: message
        });
    }

</script>
@endpush
