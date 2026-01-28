@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')

    <div class="row row-cols-1 mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Usuarios del sistema') }}</h5>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-right">Crear Usuario</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Correo Electrónico') }}</th>
                                <th>{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        <a href="{{ route('usuarios.show', $user) }}" class="btn btn-sm btn-info">Ver</a>
                                        <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
</x-app-layout>
