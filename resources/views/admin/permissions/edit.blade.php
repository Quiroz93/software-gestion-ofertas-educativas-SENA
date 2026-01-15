@extends('layouts.app')

@section('title', 'Editar Permiso')

@section('content_header')
    <h1 class="m-0">Editar Permiso</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actualizar permiso</h3>
            </div>

            <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- Categoría --}}
                    <div class="form-group mb-3">
                        <label for="category">Categoría</label>
                        <input
                            id="category"
                            type="text"
                            name="category"
                            class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category', $category) }}"
                            placeholder="usuarios, roles, reportes"
                            required
                        >
                        @error('category')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Acción --}}
                    <div class="form-group mb-3">
                        <label for="action">Acción</label>
                        <input
                            id="action"
                            type="text"
                            name="action"
                            class="form-control @error('action') is-invalid @enderror"
                            value="{{ old('action', $action) }}"
                            placeholder="create, edit, delete, view"
                            required
                        >
                        @error('action')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Guard --}}
                    <div class="form-group mb-3">
                        <label for="guard_name">Guard Name</label>
                        <input
                            id="guard_name"
                            type="text"
                            name="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            value="{{ old('guard_name', $permission->guard_name) }}"
                            required
                        >
                        @error('guard_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>
</div>

@stop
