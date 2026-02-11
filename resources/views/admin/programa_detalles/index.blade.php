@extends('layouts.admin')
@section('content')
<h1>Detalles de Programas</h1>
<a href="{{ route('admin.programa_detalles.create') }}" class="btn btn-primary mb-3">Crear nuevo detalle</a>
<table class="table align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Programa</th>
            <th>Contextualización</th>
            <th>Video</th>
            <th>Imágenes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalles as $detalle)
        <tr>
            <td>{{ $detalle->id }}</td>
            <td>{{ $detalle->programa_id }}</td>
            <td style="max-width:200px; white-space:pre-line;">{{ Str::limit($detalle->contextualizacion, 100) }}</td>
            <td>
                @if($detalle->video_url)
                    <a href="{{ $detalle->video_url }}" target="_blank">Ver video</a>
                @elseif($detalle->video_file)
                    <video width="120" height="80" controls>
                        <source src="data:video/mp4;base64,{{ base64_encode($detalle->video_file) }}" type="video/mp4">
                        Video
                    </video>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>
            <td>
                <div class="d-flex flex-wrap gap-1">
                    @if($detalle->imagenes_blob && is_array($detalle->imagenes_blob))
                        @foreach($detalle->imagenes_blob as $img)
                            <img src="data:image/jpeg;base64,{{ $img }}" alt="Imagen" style="max-width:60px; max-height:40px; border:1px solid #ccc; border-radius:4px;">
                        @endforeach
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </div>
            </td>
            <td>
                <a href="{{ route('admin.programa_detalles.edit', $detalle) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('admin.programa_detalles.destroy', $detalle) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection