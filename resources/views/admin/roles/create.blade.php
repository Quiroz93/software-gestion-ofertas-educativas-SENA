<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Rol') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf

                        {{-- Nombre del rol --}}
                        <div class="mb-4">
                            <label for="name" class="form-label">Nombre del Rol</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control w-full"
                                value="{{ old('name') }}"
                                required>
                        </div>

                        {{-- Guard name --}}
                        <div class="mb-4">
                            <label for="guard_name" class="form-label">Guard Name</label>
                            <input
                                id="guard_name"
                                class="form-control w-full"
                                type="text"
                                name="guard_name"
                                value="{{ old('guard_name', 'web') }}"
                                required>
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
                                            id="perm_{{ $permission->id }}">

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
                        <div class="flex items-center justify-end mt-4">
                            <button class="btn btn-success ml-4">
                                {{ __('Crear Rol') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>