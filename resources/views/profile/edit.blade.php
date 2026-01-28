@extends('layouts.bootstrap')

@section('title', 'Mi Perfil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h2 mb-2">
                    <i class="bi bi-person-circle me-2"></i>Mi Perfil
                </h1>
                <p class="text-muted">Administra la información de tu cuenta y configuración</p>
            </div>

            <!-- Success Messages -->
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    @if(session('status') === 'profile-updated')
                        Perfil actualizado correctamente.
                    @elseif(session('status') === 'password-updated')
                        Contraseña actualizada correctamente.
                    @elseif(session('status') === 'photo-updated')
                        Foto de perfil actualizada correctamente.
                    @elseif(session('status') === 'photo-deleted')
                        Foto de perfil eliminada correctamente.
                    @else
                        {{ session('status') }}
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-4">
                    <!-- Profile Photo Upload -->
                    <x-profile.photo-upload :user="$user" />

                    <!-- User Card -->
                    <div class="mt-4">
                        <x-profile.user-card :user="$user" class="mb-3" />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-8">
                    <!-- Update Profile Information -->
                    <x-u-i.card class="mb-4">
                        <x-slot:header>
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>Información del Perfil
                            </h5>
                        </x-slot:header>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($user->email_verified_at === null)
                                    <small class="text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Tu correo electrónico no está verificado.
                                    </small>
                                @endif
                            </div>

                            <!-- Bio -->
                            <div class="mb-3">
                                <label for="bio" class="form-label">Biografía</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                          id="bio" 
                                          name="bio" 
                                          rows="3">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Ubicación</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $user->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="mb-3">
                                <label for="website" class="form-label">Sitio Web</label>
                                <input type="url" 
                                       class="form-control @error('website') is-invalid @enderror" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $user->website) }}" 
                                       placeholder="https://ejemplo.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </x-u-i.card>

                    <!-- Update Password -->
                    <x-u-i.card class="mb-4">
                        <x-slot:header>
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Actualizar Contraseña
                            </h5>
                        </x-slot:header>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-key me-2"></i>Actualizar Contraseña
                            </button>
                        </form>
                    </x-u-i.card>

                    <!-- Delete Account -->
                    <x-u-i.card class="border-danger">
                        <x-slot:header class="bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>Eliminar Cuenta
                            </h5>
                        </x-slot:header>

                        <p class="text-muted mb-3">
                            Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. 
                            Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                        </p>

                        <button type="button" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash me-2"></i>Eliminar Cuenta
                        </button>
                    </x-u-i.card>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<x-u-i.modal id="deleteAccountModal" centered>
    <x-slot:title>
        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Eliminar Cuenta
    </x-slot:title>

    <p>¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
    <p class="text-danger fw-bold">Todos tus datos serán eliminados permanentemente.</p>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password_delete" class="form-label">Confirma tu contraseña para continuar:</label>
            <input type="password" 
                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                   id="password_delete" 
                   name="password" 
                   placeholder="Contraseña" 
                   required>
            @error('password', 'userDeletion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
            </button>
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-2"></i>Eliminar Cuenta
            </button>
        </x-slot:footer>
    </form>
</x-u-i.modal>
@endsection
