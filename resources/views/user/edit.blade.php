@extends('template')

@section('title', 'Editar usuario')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    .input-group-text {
        cursor: pointer;
        background-color: white;
    }
    .toggle-password i {
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Usuario</a></li>
        <li class="breadcrumb-item active">Editar usuario</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('users.update',['user'=>$user]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="row mb-4 mt-4">
                    <label for="name" class="col-sm-2 col-form-label">Nombres:</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">Escriba un solo nombre</div>
                    </div>
                    <div class="col-sm-2">
                        @error('name')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-4">
                        <input type="email" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}">
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">Dirección de correo electrónico</div>
                    </div>
                    <div class="col-sm-2">
                        @error('email')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="password" class="col-sm-2 col-form-label">Contraseña:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="input-group-text toggle-password" data-target="password">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">Escriba una contraseña segura. Debe incluir números</div>
                    </div>
                    <div class="col-sm-2">
                        @error('password')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="password_confirm" class="col-sm-2 col-form-label">Confirmar:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                            <span class="input-group-text toggle-password" data-target="password_confirm">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">Vuelva a escribir su contraseña</div>
                    </div>
                    <div class="col-sm-2">
                        @error('password_confirm')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="role" class="col-sm-2 col-form-label">Seleccione un rol:</label>
                    <div class="col-sm-4">
                        <select name="role" id="role" class="form-select">
                            @foreach ($roles as $item)
                                <option value="{{$item->name}}" 
                                    @selected(old('role', $user->roles->pluck('name')->first()) == $item->name)>
                                    {{$item->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-text">Escoja un rol para el usuario</div>
                    </div>
                    <div class="col-sm-2">
                        @error('role')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.querySelectorAll('.toggle-password').forEach(span => {
        span.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endpush