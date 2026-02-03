@extends('layouts.admin')

@section('title', 'Importar Preinscritos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-upload text-primary"></i>
        Importación y Consolidación
    </h1>
    <div>
        <a href="{{ route('preinscritos.consolidaciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Carga múltiple de archivos Excel</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('preinscritos.consolidaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Archivos Excel (.xls, .xlsx)</label>
                    <input type="file" name="archivos[]" class="form-control" multiple accept=".xls,.xlsx" required>
                    <div class="form-text">Puede seleccionar múltiples archivos para consolidar la información.</div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Se detectarán automáticamente encabezados y se evitarán duplicados por tipo y número de documento + ficha.
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-cloud-arrow-up"></i>
                    Consolidar archivos
                </button>
            </form>
        </div>
    </div>

    @if(session('import_errors'))
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Errores encontrados</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
