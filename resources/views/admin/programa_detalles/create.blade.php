@extends('layouts.admin')
@section('content')
<h1>Crear Detalle de Programa</h1>
<form action="{{ route('admin.programa_detalles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Selecciona el programa al que se agregará el detalle</label>
        <div class="overflow-auto border rounded p-2" style="max-height: 220px; background: #f8f9fa;">
            @foreach($programas as $programa)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="programa_id" id="programa_{{ $programa->id }}" value="{{ $programa->id }}" {{ (request('programa_id') == $programa->id || old('programa_id') == $programa->id) ? 'checked' : '' }} required>
                    <label class="form-check-label" for="programa_{{ $programa->id }}">
                        {{ $programa->nombre }} <span class="text-muted">(Ficha: {{ $programa->numero_ficha }})</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-3">
        <label for="contextualizacion" class="form-label">Contextualización</label>
        <textarea name="contextualizacion" id="contextualizacion" class="form-control" rows="4" placeholder="Describe el contexto del programa...">{{ old('contextualizacion') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Video</label>
        <ul class="nav nav-tabs" id="videoTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button" role="tab" aria-controls="url" aria-selected="true">URL</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="file-tab" data-bs-toggle="tab" data-bs-target="#file" type="button" role="tab" aria-controls="file" aria-selected="false">Archivo</button>
            </li>
        </ul>
        <div class="tab-content mt-2" id="videoTabContent">
            <div class="tab-pane fade show active" id="url" role="tabpanel" aria-labelledby="url-tab">
                <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://..." value="{{ old('video_url') }}">
                <small class="form-text text-muted">Si tienes un enlace de YouTube, Vimeo u otro, colócalo aquí.</small>
            </div>
            <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
                <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*">
                <small class="form-text text-muted">Puedes subir un archivo de video si no tienes URL.</small>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="imagenes" class="form-label">Imágenes</label>
        <input type="file" name="imagenes[]" id="imagenes" class="form-control" accept="image/*" multiple>
        <small class="form-text text-muted">Puedes seleccionar varias imágenes.</small>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

@push('scripts')
<script>
    // Mantener la pestaña activa después de enviar el formulario
    document.addEventListener('DOMContentLoaded', function () {
        var urlTab = document.getElementById('url-tab');
        var fileTab = document.getElementById('file-tab');
        var urlInput = document.getElementById('video_url');
        var fileInput = document.getElementById('video_file');
        if(urlInput.value) {
            urlTab.classList.add('active');
            fileTab.classList.remove('active');
            document.getElementById('url').classList.add('show', 'active');
            document.getElementById('file').classList.remove('show', 'active');
        } else if(fileInput.value) {
            fileTab.classList.add('active');
            urlTab.classList.remove('active');
            document.getElementById('file').classList.add('show', 'active');
            document.getElementById('url').classList.remove('show', 'active');
        }
    });
</script>
@endpush
@endsection