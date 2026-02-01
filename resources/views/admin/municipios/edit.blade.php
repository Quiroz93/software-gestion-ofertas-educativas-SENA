@extends('layouts.admin')

@section('title', 'Editar Municipio')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-pencil-square text-sena"></i>
        Editar Municipio
    </h1>

    <a href="{{ route('municipios.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-geo-alt me-2"></i>
                    Actualizar información del Municipio
                </h5>
            </div>

            <form action="{{ route('municipios.update', $municipio) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    @include('admin.municipios._form')
                </div>

                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                    <a href="{{ route('municipios.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Actualizar Municipio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .text-sena {
        color: #39A900;
    }
    
    .btn-success {
        background-color: #007832;
        border-color: #007832;
    }
    
    .btn-success:hover {
        background-color: #39A900;
        border-color: #39A900;
    }
    
    .form-control:focus {
        border-color: #39A900;
        box-shadow: 0 0 0 0.25rem rgba(57, 169, 0, 0.25);
    }
    
    .is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
</style>
@endsection
