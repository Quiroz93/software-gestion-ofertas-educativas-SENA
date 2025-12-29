@extends('adminlte::page')
@section('title')
Centros   
@endsection
@section('content')
<div class="container-fluid">

    <a href="{{-- enlace hacia vista crear--}}" class="btn btn-success">Agregar Centro</a>
    <a href="{{-- enlace hacia vista incex--}}" class="btn btn-primary">Volver</a>

    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- logica de foreach --}}
            <tr>
                <td>{{-- logica de id --}}</td>
                <td>{{-- logica de nombre --}}</td>
                <td>{{-- logica de direccion --}}</td>
                <td>{{-- logica de telefono --}}</td>
                <td>{{-- logica de correo --}}</td>
                <td>{{-- se debe agregar botones eliminar y editar--}}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection


