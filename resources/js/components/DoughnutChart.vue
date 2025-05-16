<!-- https://vue-chartjs.org/guide/ -->
<template>
  <div v-if="hasData">
    <Doughnut :data="chartData" :options="chartOptions" />
  </div>
  <div v-else class="no-data">
    <p>No hay datos para mostrar</p>
  </div>
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
  },
  tituloChart: {
    type: String,
    required: true
  },
  etiquetas: {
    type: Array,
    required: true
  }
})

/* Comprobar si hay datos para mostrar */
/* Se comprobará en el template y si no hay, se muestra un mensaje de que no hay datos para mostrar */
const hasData = computed(() => {
  return props.datosChart.some(value => value > 0)
})

/* Etiquetas y colores */
const labels = props.etiquetas;
const colors = ['#FFBA08', '#3F88C5', '#D00000'];

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
      text: props.tituloChart,
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
