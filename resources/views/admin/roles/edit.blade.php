<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nombre del rol --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del rol</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control"
                                   value="{{ old('name', $role->name) }}"
                                   required>

                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Permisos --}}
                        <div class="mb-3">
                            <label class="form-label">Permisos</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   id="perm_{{ $permission->id }}"
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                            <label class="form-check-label"
                                                   for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Botón --}}
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success">
                                Actualizar rol
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
