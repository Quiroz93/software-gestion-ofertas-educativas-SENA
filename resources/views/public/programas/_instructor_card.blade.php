<!-- resources/views/public/programas/_instructor_card.blade.php -->
<div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInRight">
    <div class="card-body">
        <h5 class="fw-bold mb-3 text-sena-blue">
            <i class="bi bi-person-badge me-2"></i>Perfil del Instructor
        </h5>
        <div class="d-flex align-items-center mb-3">
            <div class="flex-shrink-0 me-3">
                <i class="bi bi-person-circle" style="font-size: 2.5rem; color: var(--sena-blue);"></i>
            </div>
            <div>
                <h6 class="mb-1 fw-bold">{{ $instructor->nombre ?? 'Nombre no disponible' }} {{ $instructor->apellidos ?? '' }}</h6>
                <small class="text-muted">{{ $instructor->correo ?? 'Correo no disponible' }}</small>
            </div>
        </div>
        <p class="mb-2"><strong>Perfil profesional:</strong><br>{{ $instructor->perfil_profesional ?? 'No disponible' }}</p>
        <p class="mb-0"><strong>Experiencia:</strong><br>{{ $instructor->experiencia ?? 'No disponible' }}</p>
    </div>
</div>