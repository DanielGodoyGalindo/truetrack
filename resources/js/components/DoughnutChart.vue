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
import { color } from 'chart.js/helpers'

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
const colors = ['#FFBA08', '#3F88C5', '#D00000']

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
      text: 'Mis envíos',
      font: {
        size: 28
      },
    },
  },
}
</script>

<style scoped>
* {
  width: 400px;
  height: 400px;
  margin: 0 auto;
}
</style>
