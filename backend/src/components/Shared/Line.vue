<script setup>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'


ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const data = {
  labels: ['一月', '二月', '三月', '四月', '五月', '六月', '七月'],
  datasets: [
    {
      label: '訪客人數',
      backgroundColor: '#f87979',
      data: [40, 39, 10, 40, 39, 80, 40]
    },
    {
      label: '點擊次數',
      backgroundColor: '#2CA8FF',
      data: [10, 55, 55, 80, 40, 10, 50]
    }
  ]
}

const options = {
  responsive: true,
  maintainAspectRatio: false
}
</script>

<template>
    <Line :data="data" :options="options" />
</template>

<style lang="scss" scoped>
</style>