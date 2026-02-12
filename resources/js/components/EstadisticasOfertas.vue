<template>
  <div>
    <div class="filters">
      <label>Año:
        <select v-model="filtros.anio" @change="fetchData">
          <option value="">Todos</option>
          <option v-for="anio in anios" :key="anio" :value="anio">{{ anio }}</option>
        </select>
      </label>
      <label>Oferta:
        <select v-model="filtros.oferta_id" @change="fetchData">
          <option value="">Todas</option>
          <option v-for="oferta in ofertas" :key="oferta.id" :value="oferta.id">{{ oferta.nombre }}</option>
        </select>
      </label>
      <label>Programa:
        <select v-model="filtros.programa_id" @change="fetchData">
          <option value="">Todos</option>
          <option v-for="programa in programas" :key="programa.id" :value="programa.id">{{ programa.nombre }}</option>
        </select>
      </label>
    </div>
    <BarChart
      v-if="chartData"
      :chart-data="chartData"
      :options="chartOptions"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import BarChart from './BarChart.vue'; // Componente wrapper para Chart.js

const filtros = ref({ anio: '', oferta_id: '', programa_id: '' });
const anios = ref([]);
const ofertas = ref([]);
const programas = ref([]);
const chartData = ref(null);
const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: { position: 'top' },
    title: { display: true, text: 'Evolución de Ofertas Educativas' },
    tooltip: { mode: 'index', intersect: false },
  },
  scales: {
    x: { stacked: true },
    y: { stacked: true, beginAtZero: true },
  },
});

async function fetchData() {
  const { anio, oferta_id, programa_id } = filtros.value;
  const { data } = await axios.get('/admin/estadisticas-preinscritos/metricas', {
    params: { anio, oferta_id, programa_id },
  });
  // Procesar datos para la gráfica
  procesarDatos(data);
}

function procesarDatos(data) {
  // Extraer labels y datasets
  const labels = data.inscritos_por_oferta.map(o => `Oferta ${o.oferta_id}`);
  const inscritos = data.inscritos_por_oferta.map(o => o.total_inscritos);
  const rechazados = data.preinscritos_metricas.map(o => o.rechazados);
  const conNovedad = data.preinscritos_metricas.map(o => o.con_novedad);
  const solucionadas = data.preinscritos_metricas.map(o => o.novedades_solucionadas);
  const pendientes = data.preinscritos_metricas.map(o => o.novedades_pendientes);

  chartData.value = {
    labels,
    datasets: [
      {
        label: 'Inscritos',
        backgroundColor: '#4caf50',
        data: inscritos,
      },
      {
        label: 'Rechazados',
        backgroundColor: '#f44336',
        data: rechazados,
      },
      {
        label: 'Con Novedad',
        backgroundColor: '#ff9800',
        data: conNovedad,
      },
      {
        label: 'Novedades Solucionadas',
        backgroundColor: '#2196f3',
        data: solucionadas,
      },
      {
        label: 'Novedades Pendientes',
        backgroundColor: '#9c27b0',
        data: pendientes,
      },
    ],
  };
}

async function fetchFiltros() {
  // Cargar años, ofertas y programas para los filtros
  const { data } = await axios.get('/admin/estadisticas-preinscritos/filtros');
  anios.value = data.anios;
  ofertas.value = data.ofertas;
  programas.value = data.programas;
}

onMounted(async () => {
  await fetchFiltros();
  await fetchData();
});
</script>

<style scoped>
.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}
</style>
