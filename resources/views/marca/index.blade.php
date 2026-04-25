@extends('template')

@section('title','marcas')

@push('css') 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')


@if(session('success'))
<script>
let message = "{{ session('success') }}";

const Toast = Swal.mixin({
  toast: true,
  position: "top-end", 
  showConfirmButton: false,
  timer: 2400,
  timerProgressBar: false,
  background: "#f2f2f7",
  color: "#111",
  width: "auto",
  padding: "18px 24px", 
  customClass: {
    popup: "ios-toast-right",
    title: "ios-toast-title-right",
    icon: "ios-toast-icon-right"
  },
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

if (message) {
  Toast.fire({
    icon: "success",
    title: message
  });
}
</script>

<style>
.ios-toast-right {
  border-radius: 18px !important;
  box-shadow: 0 10px 26px rgba(0,0,0,0.2) !important;
  max-width: 95vw;
}

/* Texto */
.ios-toast-title-right {
  font-size: 17px !important; 
  font-weight: 500 !important;
  text-align: left !important;
}

/* Icono */
.ios-toast-icon-right {
  font-size: 20px !important; 
}

/* Mobile */
@media (max-width: 576px) {
  .ios-toast-right {
    margin-top: 12px;
    padding: 16px 20px;
  }

  .ios-toast-title-right {
    font-size: 15px !important;
  }
}
</style>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Marcas</li>
    </ol>
    @can('crear-marca')
    <div class="mb-4">
        <a href="{{route('marcas.create')}}">
            <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
        </a>
    </div>
    @endcan

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Marcas
        </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $marca)
                        <tr>
                            <td>
                                {{$marca->caracteristica->nombre}}
                            </td>
                            <td>
                                {{$marca->caracteristica->descripcion}}
                            </td>
                            <td>
                                @if ($marca->caracteristica->estado == 1)
                                    <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                @else
                                    <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>

                                @endif
                            </td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    @can('editar-marca')
                                    <form action="{{route('marcas.edit',['marca'=>$marca])}}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    @endcan

                                    @can('eliminar-marca')
                                    @if ($marca->caracteristica->estado == 1)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$marca->id}}">Eliminar</button>
                                    @else
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$marca->id}}">Restaurar</button>
                                    @endif
                                    @endcan

                                </div>
                            </td>
                        </tr>  
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{$marca->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                {{ $marca->caracteristica->estado == 1 ? '¿Seguro que quieres eliminar la marca?' : '¿Seguro que quieres restaurar la marca?' }}
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{ route('marcas.destroy',['marca'=>$marca->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush

