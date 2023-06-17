
<script setup>
import {
Chart as ChartJS,
Title,
Tooltip,
Legend,
BarElement,
CategoryScale,
LinearScale,
} from 'chart.js'
import { Bar } from 'vue-chartjs'
import { ref, onMounted, computed, toRefs, watch } from "vue";
import axiosClient from "@/axios";
const emit = defineEmits(['finish']);
const props = defineProps(['minuteSearch']);
const search = ref(1);
search.value = props.minuteSearch
console.log(props.minuteSearch);
const minutes = ref([])
const reloadChart = ref(0)
onMounted(()=>{
    getMinutes();
})
watch(()=>props.minuteSearch, (val) => {
    search.value = val
    getMinutes(search.value)
})
const coursesArr = ref([])
const minutesArr = ref([])
const getMinutes = ( search=1) => {
    axiosClient.get('/minutes', {params: {search}}).then(res=>{
        minutes.value = Object.values(res.data.data.reduce((acc, curr) => {
        if (!acc[curr.course]) {
            acc[curr.course] = { ...curr };
        } else {
            acc[curr.course].minutes += curr.minutes;
        }
        return acc;
        }, {}));


        coursesArr.value = minutes.value.map(e=> e.course)
        minutesArr.value = minutes.value.map(e=> e.minutes)

        data.labels = coursesArr.value
        data.datasets[0].data = minutesArr.value
        reloadChart.value ++
        emit('finish', true);
        
    })
}
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)
const data = {
  labels: [],
  datasets: [
    {
      label: '本日網站停留時間統計(單位:分鐘)',
      backgroundColor: '#0074B4',
      data:[]
    }
  ]
}
const options = {
  responsive: true,
  maintainAspectRatio: false,

};


</script>

<template>
    <div>
        <Bar :data="data" :options="options"  :key="reloadChart" />
    </div>
</template>
  
<style lang="scss" scoped>
    div{
        height: 250px;
    }
</style>
