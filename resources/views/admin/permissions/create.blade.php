@extends('layouts.admin')

@section('title', 'Crear Permiso')

@section('content_header')
    <h1 class="m-0">Crear Permiso</h1>
@stop

@section('content')

{{-- Categoría --}}
<div class="form-group mb-3">
    <label for="category">Categoría</label>

    <select
        id="category"
        name="category"
        class="form-control @error('category') is-invalid @enderror"
        required
    >
        <option value="">Seleccione una categoría</option>

        @foreach($categories as $category)
            <option value="{{ $category }}"
                {{ old('category') === $category ? 'selected' : '' }}>
                {{ ucfirst($category) }}
            </option>
        @endforeach

        <option value="_new">+ Nueva categoría</option>
    </select>

    @error('category')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

{{-- Nueva categoría --}}
<div class="form-group mb-3 d-none" id="new-category-group">
    <label for="new_category">Nueva categoría</label>
    <input
        id="new_category"
        type="text"
        class="form-control"
        placeholder="ej: centros, contratos"
    >
</div>


@push('scripts')
<script>
    const categorySelect = document.getElementById('category');
    const newCategoryGroup = document.getElementById('new-category-group');

    categorySelect.addEventListener('change', function () {
        newCategoryGroup.classList.toggle('d-none', this.value !== '_new');
    });
</script>
@endpush


@stop
