@extends('template')

@section('title','Perfil')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


.ios-toast-title-right {
  font-size: 17px !important; 
  font-weight: 500 !important;
  text-align: left !important;
}


.ios-toast-icon-right {
  font-size: 20px !important;
}


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

<div class="container">
    <h1 class="mt-4 text-center">Configurar perfil</h1>
    <div class="container card mt-4">
        <div class="mt-4">
            @if ($errors->any())
            @foreach ($errors->all() as $item)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$item}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            @endif
        </div>
    
        <form class="card-body" action="{{route('profile.update',['profile' => $user])}}" method="POST">
            @method('PATCH')
            @csrf
            <!--Nombre-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Nombres">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}">
                </div>
            </div>

            <!--Email-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Email">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}">
                </div>
            </div>

            <!--Password-->
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Contraseña">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="col text-center">
                <input class="btn btn-success" type="submit" value="Guardar cambios">
            </div>
        </form>

    </div>
</div>

@endsection

@push('js')

@endpush