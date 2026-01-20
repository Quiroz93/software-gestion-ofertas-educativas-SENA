@extends('layouts.app')

@section('title', 'Permisos')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Permisos por categoría</h1>
    <div class="d-flex justify-content-end align-items-center">
        <a href="{{ route('permissions.create') }}" class="btn btn-outline-success me-1">
            <i class="fas fa-plus-circle"></i>
            Crear permiso
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')



@foreach($permissions as $category => $items)
<div class="card mb-3 card-shadow card-outline card-primary">
    <div class="card-header">
        <strong>{{ strtoupper($category) }}</strong>
    </div>

    <div class="card-body px-4 py-3 card-shadow">
        <div class="row">
            @foreach($items as $permission)
            <div class="col-md-4 mb-2">
                <div class="d-flex justify-content-between">
                    <span>{{ $permission->name }}</span>
                    <a href="{{ route('permissions.edit', $permission) }}"
                        class="btn btn-sm btn-outline-warning">
                        Editar
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

@endsection