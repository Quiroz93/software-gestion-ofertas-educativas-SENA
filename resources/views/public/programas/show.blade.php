@extends('public.layouts.app')

@section('title', 'Programa de formación')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="card-title text-uppercase fw-bold">
                {{ $programa->nombre }}
            </h2>
        </div>

        <div class="card-body">
            <p class="mb-2">
                <strong>Descripción:</strong><br>
                {{ $programa->descripcion }}
            </p>

            <p class="mb-2">
                <strong>Requisitos:</strong><br>
                {{ $programa->requisitos }}
            </p>

            <a href="{{ route('public.programas.index') }}" class="btn btn-outline-secondary mt-3">
                <i class="fas fa-arrow-left"></i>
                Volver a Programas
            </a>
        </div>
    </div>