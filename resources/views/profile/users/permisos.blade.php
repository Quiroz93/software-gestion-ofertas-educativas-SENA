@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

<form method="POST" action="{{ route('usuarios.updatepermisos', $user) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Roles</label>
        @foreach($roles as $role)
            <div class="form-check">
                <input type="checkbox"
                       name="roles[]"
                       value="{{ $role->name }}"
                       {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                <label>{{ $role->name }}</label>
            </div>
        @endforeach
    </div>

    <div class="form-group mt-3">
        <label>Permisos</label>
        @foreach($permissions as $permission)
            <div class="form-check">
                <input type="checkbox"
                       name="permissions[]"
                       value="{{ $permission->name }}"
                       {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                <label>{{ $permission->name }}</label>
            </div>
        @endforeach
    </div>

    <button class="btn btn-success mt-3">Guardar</button>
</form>

@endsection
