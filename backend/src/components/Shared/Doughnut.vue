<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Doughnut } from 'vue-chartjs';
const props = defineProps(['visitor', 'watched'])

ChartJS.register(ArcElement, Tooltip, Legend);
const data = {
  labels: ['訪客人數', '點擊次數'],
  datasets: [
    {
      backgroundColor: [ '#0074B4', '#34C38F',],
      data: [props.visitor, props.watched]
    }
  ]
}
const options = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
  tooltip: {
      callbacks: {
        label: function(context) {
          return null; // 返回null来隐藏标签
        }
      }
    }

};

</script>

<template>
  <div>
    <Doughnut :data="data" :options="options" />
  </div>
</template>

<style lang="scss" scoped>
  div{
    width: 60px;
    height: 60px;
  }
</style>