@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content_header')
    <h1 class="m-0">Crear Rol</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nuevo Rol</h3>
            </div>

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Nombre del Rol</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                            autofocus
                        >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="guard_name">Guard</label>
                        <input
                            type="text"
                            name="guard_name"
                            id="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            value="{{ old('guard_name', 'web') }}"
                            required
                        >
                        @error('guard_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Crear Rol
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@stop
