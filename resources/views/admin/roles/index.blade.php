<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create_roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-4 mt-3">{{ __('Crear Nuevo Rol') }}</a>
                    @endcan

                    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-4 mt-3">Volver</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Nombre del Rol') }}</th>
                                <th>{{ __('Name_Guard') }}</th>
                                <th>{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">{{ __('Editar') }}</a>
                                    
                                    @can('delete_roles')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="confirmarEliminacion(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Eliminar') }}</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>