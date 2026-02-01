@extends('layouts.bootstrap')

@section('title', 'Mi Perfil - Programas')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Tarjeta de Usuario --}}
        <div class="col-lg-4 mb-4">
            <x-profile.user-card :user="$user" />
        </div>

        {{-- Programas del Usuario --}}
        <div class="col-lg-8">
            <x-profile.user-programs :user="$user" />
        </div>
    </div>
</div>
@endsection
