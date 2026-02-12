<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Preinscritos</h6>
                <h2 class="fw-bold text-sena">{{ $kpis['total'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Con Novedad</h6>
                <h2 class="fw-bold text-warning">{{ $kpis['con_novedad'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Novedad Resuelta</h6>
                <h2 class="fw-bold text-success">{{ $kpis['novedad_resuelta'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Estados</h6>
                <ul class="list-unstyled mb-0">
                    @foreach($kpis['por_estado'] as $estado => $total)
                        <li><span class="fw-semibold">{{ $estado }}:</span> {{ $total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
