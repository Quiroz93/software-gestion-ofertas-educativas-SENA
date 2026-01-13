@extends('adminlte::page')

@section('title', config('app.name', 'SENA'))

@section('body_class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/">
            <b>{{ config('app.name', 'SENA') }}</b>
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    body.login-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-box {
        width: 100%;
        max-width: 400px;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-logo a {
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }

    .login-box .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .login-box .card-body {
        padding: 30px;
    }
</style>
@endsection
