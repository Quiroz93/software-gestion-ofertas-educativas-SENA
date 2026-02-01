@extends('layouts.admin')

@section('title', 'Crear Municipio')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-plus-circle text-sena"></i>
        Nuevo Municipio
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
                    Información del Municipio
                </h5>
            </div>

            <form action="{{ route('municipios.store') }}" method="POST">
                @csrf
                
                <div class="card-body">
                    @include('admin.municipios._form')
                </div>

                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                    <a href="{{ route('municipios.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-sena">
                        <i class="bi bi-check-circle"></i>
                        Guardar Municipio
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
    
    .btn-primary-sena {
        background-color: #39A900;
        border-color: #39A900;
        color: #fff;
    }
    
    .btn-primary-sena:hover {
        background-color: #007832;
        border-color: #007832;
        color: #fff;
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
