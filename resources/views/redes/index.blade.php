@extends('layouts.app')

@section('title', 'Redes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-network-wired text-primary"></i>
        Gestión de redes
    </h1>
    <div>
        @can('programas.create')
        <a href="{{route('redes_conocimiento.create')}}" class="btn btn-outline-success">
            <i class="fas fa-plus-circle"></i>
            Nueva red de conocimiento
        </a>
        @endcan
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')

@if($redes->isEmpty())
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen redes registradas.
</div>
@endif

<div class="row">
    @foreach($redes as $red)
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold text-uppercase">
                    {{ $red->nombre }}
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">
                <p class="mb-0">
                    <strong>Descripción:</strong><br>
                    <span class="badge badge-secondary">
                        {{ $red->descripcion }}
                    </span>
                </p>
            </div>

            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">

                <div>
                    @can('redes_conocimiento.edit')
                    <a href="{{-- enlace editar --}}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                    @endcan
                </div>

                @can('redes_conocimiento.delete')
                <form action="{{-- enlace eliminar --}}"
                    method="POST"
                    onsubmit="return confirmarEliminacion(event)">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </button>
                </form>
                @endcan

            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection