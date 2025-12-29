@extends('adminlte::page')
@section('title')
Centros   
@endsection
@section('content')
<div class="container-fluid">
    <button class="btn btn-success">Agregar Centro</button>
    <button class="btn btn-primary">Volver</button>

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
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button class="btn btn-info">Editar</button>
                    <button class="btn btn-danger">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection


