@extends('adminlte::page')
@section('title')
Centros   
@endsection
@section('content')
 <div class="container">
    <div class="row">
        {{-- Título de la página --}}
        <div class="col-12">
            <h1 class="text-center font-weight-bold mb-3">Agregar Centro</h1> 
        </div>
        {{-- Botones de acción --}}
        <div class="col-12">
            <a href="{{-- enlace hacia vista index--}}" class="btn btn-primary">Volver</a>
        </div>
        {{-- Formulario de creación de centro --}}
        <div class="col-12">
        <form action="{{-- aqui se enlaza el controlador--}}" class="form">
            @csrf
            <div class="row">
                <div class="col-6">
                    <label for="nombre" class="form-label mt-3">Nombre del Centro</label>
                    <input type="text" class="form-control" name="nombre" id="nombre">
                </div>
                <div class="col-6">
                    <label for="direccion" class="form-label mt-3">Dirección del Centro</label>
                    <input type="text" class="form-control" name="direccion" id="direccion">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="telefono" class="form-label mt-3">Telefono del Centro</label>
                    <input type="text" class="form-control" name="telefono" id="telefono">
                </div>
                <div class="col-6">
                    <label for="correo" class="form-label mt-3">Correo del Centro</label>
                    <input type="email" class="form-control" name="correo" id="correo">
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-success">Guardar Centro</button>
                </div>
        </form>
    </div>
    </div>
    

@endsection