<section class="mb-4">
    <header class="mb-4">
        <h2 class="h5 fw-bold text-dark">
            {{ __('Eliminar Cuenta') }}
        </h2>
        <p class="small text-secondary mt-2">
            {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        {{ __('Eliminar Cuenta') }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('¿Está seguro de que desea eliminar su cuenta?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    <div class="modal-body">
                        @csrf
                        @method('delete')

                        <p class="small text-secondary mb-3">
                            {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.') }}
                        </p>

                        <div>
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @error('userDeletion.password') is-invalid @enderror"
                                placeholder="{{ __('Contraseña') }}"
                                required
                            />
                            @error('userDeletion.password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('Eliminar Cuenta') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
