<script setup>
import DoughnutChart from "../components/Shared/Doughnut.vue"
import LineChart from "../components/Shared/Line.vue"
import BarChart from "../components/Shared/Bar.vue"
import { ref, onMounted, computed, toRefs } from "vue";
import store from "../store";
const courses = computed(() => store.state.courses);
const letters = computed(() => store.state.letters);
const courseLoading = ref(true);
const minuteLoading = ref(true)
const letterLoading = ref(true)
const minuteSearch = ref(1);
const date = ref(1)
onMounted(()=>{
    getCourses();
    getLetters();
})
const toggleDate = (n)=>{
    minuteLoading.value = true
    minuteSearch.value = n
}
const barFinish = ()=>{
    minuteLoading.value = false
}

const openUL = (ev)=>{
    if(ev.target.previousSibling.classList.contains('open')){
        ev.target.previousSibling.classList.remove('open')
    }else{
        ev.target.previousSibling.classList.add('open')
    }
}
const deleteLetter = (letter) => {
  if (!confirm(`確定要刪除 ${letter.name}(${letter.phone}) 嗎？`)) return;
  store.dispatch("deleteLetter", letter.id).then((res) => {
    alert("刪除成功！");
    getLetters();
  });
};
const getCourses = (url = null) => {
  store.dispatch("getCourses", {
    url,
  }).then(()=>{
    courseLoading.value = false
  });
};
const getLetters = (url = null) => {
    letterLoading.value = true
    store.dispatch("getLetters", {
        url,
        date: date.value,
    }).then(()=>{
        letterLoading.value = false
    });
};
</script>

<template>
    <div class="dashboard" >
        <h1>Dashboard</h1>
        <div class="cards" v-if="!courseLoading">
            <div class="card" v-for="course in courses.data" :key="course.id">
                <div class="text">
                    <h2>{{course.title}}</h2>
                </div>
                <div class="numbers">
                    <div class="mr-5">
                        <span class="visitor">訪客人數</span>
                        <p v-run>{{course.visitor}}</p>
                    </div>
                    <div class="mr-5">
                        <span class="watched">點擊次數</span>
                        <p v-run>{{course.watched}}</p>
                    </div>
                    <div>
                        <DoughnutChart :visitor="course.visitor" :watched="course.watched" />
                    </div>
                </div>
            </div>
        </div>
        <div class="cards-loading" v-else>
            <svg
              class="animate-spin h-5 w-5 text-gray-500"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
        </div>
        <div class="content mt-10">
            <div class="line ">
                <div class="title">
                    <h2>網站的訪客人數以及點擊次數</h2>
                    <div class="btns">
                        <button :class="{'active': minuteSearch == 1}" @click="toggleDate(1)">本日</button>
                        <button :class="{'active': minuteSearch == 2}" @click="toggleDate(2)">本周</button>
                        <button :class="{'active': minuteSearch == 3}" @click="toggleDate(3)">本月</button>
                        <button :class="{'active': minuteSearch == 4}" @click="toggleDate(4)">今年</button>
                        <button :class="{'active': minuteSearch == 5}" @click="toggleDate(5)">全部</button>
                    </div>
                </div>
                <div v-show="!minuteLoading">
                    <BarChart @finish="barFinish" :minuteSearch="minuteSearch" />
                </div>
                <div v-show="minuteLoading" class="bar-loading">
                    <svg
                        class="animate-spin h-5 w-5 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                        </svg>
                </div>
            </div>
            <div class="mails ">
                <div class="title">
                    <router-link :to="{name: 'app.inbox'}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                    </router-link>
                    <select @change="getLetters()" v-model="date">
                        <option value="1">本周</option>
                        <option value="2">本月</option>
                        <option value="3">全部</option>
                    </select>
                </div>
                <div class="content" v-if="!letterLoading">
                    <div class="item" v-for="letter in letters.data" :key="letter.id">
                        <div class="names">
                            <h3>{{letter.name}}</h3>
                            <span>{{letter.phone}}</span>
                            <p class="ago">{{letter.ago}}</p>
                        </div>
                        <div class="dot">
                            <ul class="isOpenUl" ref="dotUl" >
                                <router-link :to="{name: 'app.readmail', params:{id: letter.id}}">查看</router-link>
                                <button @click="deleteLetter(letter)">刪除</button>
                            </ul>
                            <svg @click="openUL($event)"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div v-else class="letter-loading">
                    <svg
                        class="animate-spin h-5 w-5 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                        </svg>
                </div>
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
            grid-template-columns: repeat(4, calc(25% - 20px));
            grid-column-gap: 20px;
            grid-row-gap: 20px;
            margin-top: 20px;
            >.card{
                display: flex;
                border-radius: 3px;
                background-color: #fff;
                box-shadow: 0 0.25rem 0.75rem rgba(18,38,63,.08);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px;
                width: 100%;
                
                min-width: 250px;
                >.text{
                    width: 100%;
                    >h2{
                        width: 100%;
                        text-align: left;
                        font-size: 14px;
                        color:#444;
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
                >.numbers{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    margin-top: 12px;
                    >div{
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        span{
                            font-size: 13px;
                            color:#777;
                        }
                        p{
                            font-size: 24px;
                            color:#111;
                        }
                    }
                }
                >.chart{
                    width: 100px;
                    height: 120px;
                }
            }
        }
        >.cards-loading{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 0;
        }
        >.content{
            display: flex;
            width: calc(100% - 20px);
            .line{
                border-radius: 3px;
                background-color: #fff;
                box-shadow: 0 0.25rem 0.75rem rgba(18,38,63,.08);
                padding: 30px 20px;
                width: 70%;
                >.title{
                    >h2{
                        color: #777;
                        font-size: 14px;
                        margin-bottom: 15px;
                    }
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 20px;
                    >.btns{
                        display: flex;
                        align-items: center;
                        >button{
                            padding: 5px 10px;
                            border:1px #ddd solid;
                            color:#888;
                            font-size: 12px;
                            border-radius: 4px;
                            margin-left: 6px;
                            &.active{
                                border-color:#0074B4;
                                color:#0074B4;
                            }
                        }
                    }
                }
                .bar-loading{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    height: 100%;
                }
            }
            >.mails{
                width:calc(30% - 20px);
                background-color: #fff;
                box-shadow: 0 0.25rem 0.75rem rgba(18,38,63,.08);
                border-radius: 3px;
                padding: 30px 20px;
                box-sizing: border-box;
                margin-left: 20px;
                >.title{
                    display: flex;
                    justify-content: space-between;
                    padding: 10px;
                    border-bottom: 1px #ddd solid;
                    >h2{
                        color:#555;
                        font-size: 14px;
                    }
                    >select{
                        outline: none;
                        border:none;
                        color:#555;
                        font-size: 14px;
                        border-radius: 3x;
                        padding: 1px 6px;
                    }
                }
                >.content{
                    width: 100%;
                    height: 250px;
                    overflow-y: scroll;
                    &::-webkit-scrollbar {
                        width: 5px;
                    }
                    &::-webkit-scrollbar-button {
                        background: transparent;
                        border-radius: 4px;
                    }

                    &::-webkit-scrollbar-track-piece {
                        background: #ddd;
                    }

                    &::-webkit-scrollbar-thumb {
                        border-radius: 4px;
                        background-color: rgba(0, 0, 0, 0.4);
                        border: 1px solid slategrey;
                    }

                    &::-webkit-scrollbar-track {
                        box-shadow: transparent;
                    }
                    >.item{
                        width: 100%;
                        display: grid;
                        grid-template-columns: 90% 10%;
                        align-items: center;
                        grid-column-gap: 5px;
                        padding:10px 10px ;
                        border-bottom: 1px #ddd solid;
                        box-sizing: border-box;
                        >.names{
                            display: flex;
                            flex-direction: column;
                            padding-right: 10px;
                            h3{
                                font-size: 13px;
                                color:#555;
                            }
                            span{
                                font-size: 14px;
                                color:#111;
                                font-weight: 600;
                            }
                            p.ago{
                                float: right;
                                font-size: 12px;
                                color:#777;
                                margin-left: auto;
                            }
                        }
                        >.ago{
                            font-size: 12px ;
                            color:#666;
                        }
                        >.dot{
                            position: relative;
                            ul{
                                position: absolute;
                                width: 70px;
                                flex-direction: column;
                                top: 20px;
                                left:-55px;
                                background-color: #fff;
                                z-index: 10;
                                border: 1px #ddd solid;
                                font-size: 13px;
                                color:#777;
                                display: none;
                                z-index: 1111;
                                &.open{
                                    display: flex;
                                }
                                >a, button{
                                    padding: 5px 10px ;
                                    border-bottom: 1px #f1f1f1 solid;
                                    transition: .3s;
                                    animation: show .1s linear;
                                    text-align: left;
                                    @keyframes show {
                                        0%{
                                            opacity: 0;
                                            transform: translateY(5px);
                                        }
                                    }
                                    &:hover{
                                        background-color: #f1f1f1 ;
                                    }
                                }

                            }
                            svg{
                                transform: rotate(90deg);
                                cursor: pointer;
                            }
                        }
                    }
                }
                >.letter-loading{
                    width: 100%;
                    height: 250px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
            }
        }
        
    }
</style>