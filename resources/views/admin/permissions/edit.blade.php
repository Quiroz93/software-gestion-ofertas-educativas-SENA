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

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $permission->name) }}"
                            required
                            autofocus
                        >

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
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
