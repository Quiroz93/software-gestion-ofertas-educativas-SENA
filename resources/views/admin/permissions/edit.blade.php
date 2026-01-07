<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permisos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" :value="__('Nombre')">
                            <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $permission->name)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="guard_name" :value="__('Guard Name')">
                            <input id="guard_name" class="block mt-1 w-full" type="text" name="guard_name" :value="old('guard_name', $permission->guard_name)" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="ml-4">
                                {{ __('Actualizar Permiso') }}
                            </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>