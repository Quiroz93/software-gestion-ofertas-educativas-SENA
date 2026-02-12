import Chart from 'chart.js/auto';
// Gráfico comparativo de inscritos, faltantes y rechazados por programa
const comparativoData = window.estadisticas?.grafica_programas || {};
const ctxComparativo = document.getElementById('graficoComparativoProgramas');
if (ctxComparativo && comparativoData.labels && comparativoData.labels.length) {
    new Chart(ctxComparativo, {
        type: 'bar',
        data: {
            labels: comparativoData.labels,
            datasets: [
                {
                    label: 'Inscritos',
                    data: comparativoData.inscritos,
                    backgroundColor: '#39a900', // Verde SENA
                },
                {
                    label: 'Faltantes',
                    data: comparativoData.faltantes,
                    backgroundColor: '#9ec1d4', // Azul oscuro SENA
                },
                {
                    label: 'Rechazados',
                    data: comparativoData.rechazados,
                    backgroundColor: '#ff6600', // Naranja fuerte
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const idx = context[0].dataIndex;
                            if (comparativoData.nombres && comparativoData.nombres[idx]) {
                                return comparativoData.nombres[idx];
                            }
                            return context[0].label;
                        }
                    }
                }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    // Gráfico de evolución mensual
    const evolucionData = window.estadisticas?.evolucion || {};
    const ctxEvolucion = document.getElementById('graficoEvolucion');
    if (ctxEvolucion && Object.keys(evolucionData).length) {
        new Chart(ctxEvolucion, {
            type: 'line',
            data: {
                labels: Object.keys(evolucionData),
                datasets: [{
                    label: 'Preinscritos',
                    data: Object.values(evolucionData),
                    borderColor: '#39a900',
                    backgroundColor: 'rgba(57,169,0,0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                }
            }
        });
    }

    // Gráfico de estados
    const estadosData = window.estadisticas?.por_estado || {};
    const ctxEstados = document.getElementById('graficoEstados');
    if (ctxEstados && Object.keys(estadosData).length) {
        new Chart(ctxEstados, {
            type: 'doughnut',
            data: {
                labels: Object.keys(estadosData),
                datasets: [{
                    data: Object.values(estadosData),
                    backgroundColor: ['#39a900', '#ffc107', '#dc3545', '#0d6efd', '#6c757d'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: false }
                }
            }
        });
    }

    // Gráfico de programas
    const programasData = window.estadisticas?.por_programa || {};
    const ctxProgramas = document.getElementById('graficoProgramas');
    if (ctxProgramas && Object.keys(programasData).length) {
        new Chart(ctxProgramas, {
            type: 'bar',
            data: {
                labels: Object.keys(programasData),
                datasets: [{
                    label: 'Preinscritos',
                    data: Object.values(programasData),
                    backgroundColor: '#39a900',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: {
                    x: { beginAtZero: true },
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
