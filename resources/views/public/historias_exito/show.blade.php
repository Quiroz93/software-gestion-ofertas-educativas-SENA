<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div>
@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $historia_exito->titulo }}</h1>
                <p>{{ $historia_exito->descripcion }}</p>
            </div>
        </div>
    </div>
@endsection