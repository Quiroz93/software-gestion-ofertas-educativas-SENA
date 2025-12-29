<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">
            Gestión de Ofertas
    </div>
</nav>
</body>
</html>

@extends('adminlte::page')

@section('title', 'Bienvenido | Ofertas Educativas')

@section('content_header')
    <h1 class="text-center font-weight-bold">
        Sistema de Gestión de Ofertas Educativas
    </h1>
    <p class="text-center text-muted">
        Servicio Nacional de Aprendizaje – SENA
    </p>
@stop

@section('content')
<div class="container-fluid">

    {{-- Sección bienvenida --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body text-center">
                    <h4>Bienvenido al aplicativo</h4>
                    <h6>espacio para descripción</h6>
                    <p class="mt-2">
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Centros</span>
                    <a href="{{ route('centro.index') }}" class="small text-white">
                        Gestionar centros
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Programas</span>
                    <a href="" class="small text-white">
                    class="small text-white">
                        Ver programas
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ofertas</span>
                    <a href="}}" class="small text-white">
                        Gestionar ofertas
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-secondary">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Usuarios</span>
                    <a href="}}" class="small text-white">
                        Administración
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Información institucional --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center text-muted">
                    <small>
                        SOES – Sistema de información para la gestión
                        de ofertas educativas del SENA.
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

