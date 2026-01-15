@extends('layouts.app')

@section('title', 'Permisos')

@section('content_header')
<h1 class="m-0">Permisos por categoría</h1>
@stop

@section('content')

<a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">
    Crear permiso
</a>

@foreach($permissions as $category => $items)
    <div class="card mb-3">
        <div class="card-header">
            <strong>{{ strtoupper($category) }}</strong>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach($items as $permission)
                    <div class="col-md-4 mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ $permission->name }}</span>
                            <a href="{{ route('permissions.edit', $permission) }}"
                               class="btn btn-sm btn-outline-secondary">
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
