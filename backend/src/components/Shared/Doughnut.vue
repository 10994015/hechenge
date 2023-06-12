<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Doughnut } from 'vue-chartjs';
ChartJS.register(ArcElement, Tooltip, Legend);
const data = {
  labels: ['訪客人數', '點擊次數'],
  datasets: [
    {
      backgroundColor: [ '#1C84EE', '#33C38E',],
      data: [40, 100,]
    }
  ]
}
const options = {
  responsive: true,
  maintainAspectRatio: false,
};

</script>

<template>
<Doughnut :data="data" :options="options" />
</template>

<style lang="scss" scoped>

</style>