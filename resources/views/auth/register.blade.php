@extends('layouts.auth')

@section('title', __('Registro de Usuario'))

@section('content')
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
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="pasword" class="inline-flex items-center"></label>
            <input type="checkbox" onclick="myFunction()">Ver Contraseña
            <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";        
              } else {
                x.type = "password";
              }
            }   
            </script>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Acciones -->
        <div class="flex items-center justify-between mt-6">
            <a
                href="{{ route('login') }}"
                class="text-sm text-gray-600 hover:text-gray-900 underline"
            >
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="bg-[#39A900] hover:bg-green-700">
                {{ __('Resgistrarse') }}
            </x-primary-button>
        </div>
    </form>
@endsection
