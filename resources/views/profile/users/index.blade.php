@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')

    <div class="row row-cols-1 mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Usuarios del sistema') }}</h5>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-right">Crear Usuario</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Correo Electrónico') }}</th>
                                <th>{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" style="display:inline;" class="deleteUserForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger deleteUserBtn" data-user="{{ $user->name }}">Eliminar</button>
                                        <a href="{{ route('usuarios.show', $user) }}" class="btn btn-sm btn-info">Ver</a>
                                        <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteUserBtns = document.querySelectorAll('.deleteUserBtn');
        
        deleteUserBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const userName = this.getAttribute('data-user');
                
                Swal.fire({
                    title: '¿Eliminar usuario?',
                    html: `
                        <p class="mb-3">Estás a punto de eliminar:</p>
                        <strong class="text-danger">${userName}</strong>
                        <br><br>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Esta acción no se puede deshacer
                        </p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger btn-sm',
                        cancelButton: 'btn btn-secondary btn-sm'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
</x-app-layout>
