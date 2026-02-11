@extends('layouts.admin')

@section('title', 'Contenido Público de Programas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-globe text-primary"></i>
        Contenido público de programas
    </h1>
    <a href="{{ route('admin.content_public_programas.create') }}" class="btn btn-outline-success">
        <i class="fas fa-plus-circle"></i> Nuevo contenido
    </a>
</div>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Título Hero</th>
                    <th>Título Motivacional</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contents as $content)
                <tr>
                    <td>{{ $content->programa->nombre }}</td>
                    <td>{{ $content->hero_title }}</td>
                    <td>{{ $content->motivational_title }}</td>
                    <td>
                        <a href="{{ route('admin.content_public_programas.edit', $content) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.content_public_programas.destroy', $content) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este contenido?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
