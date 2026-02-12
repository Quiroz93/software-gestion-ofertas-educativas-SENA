<template>
  <div>
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import { Chart, BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend, Title } from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend, Title);

const props = defineProps({
  chartData: { type: Object, required: true },
  options: { type: Object, default: () => ({}) },
});

const canvas = ref(null);
let chartInstance = null;

function renderChart() {
  if (chartInstance) {
    chartInstance.destroy();
  }
  chartInstance = new Chart(canvas.value, {
    type: 'bar',
    data: props.chartData,
    options: {
      ...props.options,
      plugins: {
        ...props.options.plugins,
        legend: { display: true, position: 'top' },
        tooltip: { enabled: true, mode: 'index', intersect: false },
        title: {
          display: true,
          text: props.options?.plugins?.title?.text || 'Métricas de Ofertas Educativas',
        },
      },
      responsive: true,
      scales: {
        x: { stacked: true },
        y: { stacked: true, beginAtZero: true },
      },
    },
  });
}

watch(() => props.chartData, renderChart, { deep: true });
watch(() => props.options, renderChart, { deep: true });

onMounted(() => {
  renderChart();
});

onBeforeUnmount(() => {
  if (chartInstance) {
    chartInstance.destroy();
  }
});
</script>

<style scoped>
div {
  width: 100%;
  min-height: 400px;
}
canvas {
  width: 100% !important;
  height: 400px !important;
}
</style>
