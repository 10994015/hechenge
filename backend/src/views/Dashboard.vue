<script setup>
import DoughnutChart from "../components/Shared/Doughnut.vue"
import LineChart from "../components/Shared/Line.vue"
import { ref, onMounted, computed } from "vue";
const arrData = ref([])
for(let i=0;i<5;i++){
    arrData.value.push("");
}
</script>

<template>
    <div class="dashboard">
        <h1>Dashboard</h1>
        <div class="cards" >
            <div class="card" v-for="item in arrData" :key="item">
                <div class="text">
                    <h2>國中課程</h2>
                    <span>訪客人數</span>
                </div>
                <div class="chart">
                    <DoughnutChart />
                </div>
            </div>
        </div>
        <div class="line mt-10">
            <h2>網站的訪客人數以及點擊次數</h2>
            <div>
                <LineChart />
            </div>
        </div>
    </div>
    <!-- <Doughnut :data="data" :options="options" /> -->
</template>

<style lang="scss" scoped>
    .dashboard{
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        padding: 20px 25px;
        > h1 {
            font-weight: 900;
            color: #333;
        }
        >.cards{
            display: grid;
            grid-template-columns: repeat(5, calc(20% - 20px));
            grid-column-gap: 20px;
            grid-row-gap: 20px;
            margin-top: 20px;
            >.card{
                display: flex;
                border-radius: 5px;
                background-color: #fff;
                box-shadow: 0 5px 5px #dedede;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px;
                width: 100%;
                
                min-width: 250px;
                >.text{
                    >h2{
                    font-weight: 600;
                    }
                    span{
                        color:#999;
                        font-size: 12px;
                    }
                    p{
                        font-weight: 600;
                        font-size: 32px;
                        margin-top: 5px;
                    }
                }
                >.chart{
                    width: 100px;
                    height: 120px;
                }
            }
        }
        .line{
            >h2{
                font-weight: 900;
                color: #777;
                font-size: 14px;
                margin-bottom: 15px;
            }
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 5px 5px #dedede;
            padding: 20px;
            width: 100%;
        }
    }
</style>