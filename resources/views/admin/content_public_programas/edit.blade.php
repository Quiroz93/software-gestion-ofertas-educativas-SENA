@extends('layouts.admin')

@section('title', 'Editar Contenido Público')

@section('content_header')
<h1 class="m-0"><i class="fas fa-edit text-warning"></i> Editar contenido público</h1>
@endsection

@section('content')
<form action="{{ route('admin.content_public_programas.update', $content_public_programa) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="programa_id"><strong>Programa</strong></label>
                <select name="programa_id" id="programa_id" class="form-control" required>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->id }}" {{ $content_public_programa->programa_id == $programa->id ? 'selected' : '' }}>{{ $programa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="hero_title">Título Hero</label>
                <input type="text" name="hero_title" id="hero_title" class="form-control" value="{{ $content_public_programa->hero_title }}">
            </div>
            <div class="form-group mb-3">
                <label for="hero_description">Descripción Hero</label>
                <textarea name="hero_description" id="hero_description" class="form-control">{{ $content_public_programa->hero_description }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="hero_image">Imagen Hero (URL)</label>
                <input type="text" name="hero_image" id="hero_image" class="form-control" value="{{ $content_public_programa->hero_image }}">
            </div>
            <div class="form-group mb-3">
                <label for="motivational_title">Título Motivacional</label>
                <input type="text" name="motivational_title" id="motivational_title" class="form-control" value="{{ $content_public_programa->motivational_title }}">
            </div>
            <div class="form-group mb-3">
                <label for="motivational_text">Texto Motivacional</label>
                <textarea name="motivational_text" id="motivational_text" class="form-control">{{ $content_public_programa->motivational_text }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="motivational_image">Imagen Motivacional (URL)</label>
                <input type="text" name="motivational_image" id="motivational_image" class="form-control" value="{{ $content_public_programa->motivational_image }}">
            </div>
            <div class="form-group mb-3">
                <label for="competencias_fallback">Texto Fallback Competencias</label>
                <input type="text" name="competencias_fallback" id="competencias_fallback" class="form-control" value="{{ $content_public_programa->competencias_fallback }}">
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.content_public_programas.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
    </div>
</form>
@endsection
