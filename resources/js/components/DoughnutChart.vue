<!-- https://vue-chartjs.org/guide/ -->
<template>
  <Doughnut :data="chartData" :options="chartOptions" />
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { Doughnut } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

/* Propiedades */
const props = defineProps({
  datosChart: {
    type: Array,
    required: true
  }
})

/* Etiquetas y colores */
const labels = ['Pendientes', 'En reparto', 'No entregados']
const colors = ['#facc15', '#38bdf8', '#f87171']

/* Datos generados en el controlador y obtenidos de Blade */
const chartData = computed(() => ({
  labels,
  datasets: [
    {
      label: 'Número de envíos',
      data: props.datosChart,
      backgroundColor: colors,
      borderWidth: 1,
    },
  ],
}))

const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'bottom',
    },
    title: {
      display: true,
      text: 'Mis envíos'
    },
  },
}
</script>

<style scoped>
* {
  width: 300px;
  height: 300px;
  margin: 0 auto;
}
</style>
