@section('title', 'Registro | SoeSoftware')
<x-guest-layout>
    <form
        method="POST"
        action="{{ route('register') }}"
        class="bg-white border-2 border-[#39A900] rounded-xl p-6 shadow-sm"
    >
        @csrf

        <!-- Título -->
        <h2 class="text-2xl font-bold text-center text-[#39A900] mb-6">
            Registro de Usuario
        </h2>

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- ✅ CHECK ADMINISTRATIVO -->
        <div class="mt-5 flex items-center gap-2">
            <input
                id="is_admin"
                name="is_admin"
                type="checkbox"
                value="1"
                class="h-4 w-4 text-[#39A900] focus:ring-[#39A900] border-gray-300 rounded"
            >
            <label for="is_admin" class="text-sm text-gray-700">
                Registrarse como <span class="font-semibold text-[#39A900]">administrativo</span>
            </label>
        </div>

        <!-- Acciones -->
        <div class="flex items-center justify-between mt-6">
            <a
                href="{{ route('login') }}"
                class="text-sm text-gray-600 hover:text-gray-900 underline"
            >
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-[#39A900] hover:bg-green-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
