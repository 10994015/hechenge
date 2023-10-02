<script setup>
import { computed, ref } from 'vue';
import store from "../../store";
const props = defineProps(['sortlist', 'sortOpen', 'sortLoading']);
const emit = defineEmits(['closeSortModel', 'changeSortLoading', 'successChangeSort']);
const sortableList = ref(null)
const sortlist = computed(()=> props.sortlist);
const sortOpen = computed(()=> props.sortOpen);
const sortLoading = computed(()=> props.sortLoading);

const sortArr = ref([]);
const changeSortStart = (id, event)=>{
  setTimeout(()=>{
    event.target.classList.add('dragging')
  }, 0)
};
const changeSortEnd = (id, event)=>{
  event.target.classList.remove('dragging')
};
const initSortTableList = (event)=>{
  event.preventDefault();
  const draggingItem = sortableList.value.querySelector('.dragging');
  const siblings = [...sortableList.value.querySelectorAll('.item:not(.dragging)')]
  
  let nextSibling = siblings.find(sibling=>{
    let rect = sibling.getBoundingClientRect();
    return event.clientY <= rect.top + sibling.offsetHeight / 2;
  })
  sortableList.value.insertBefore(draggingItem, nextSibling)
};

const changeSortChk = ()=>{
  emit('changeSortLoading', true)
  sortArr.value = []
  sortableList.value.querySelectorAll('.item').forEach((item, idx)=>{
    let obj = sortlist.value.find(da=> da.id == item.dataset.id)
    obj.sort = idx
  })
  const sortlistsort = sortlist.value.map(item=>{
    return {id:item.id, sort:item.sort}
  })

  emit('successChangeSort' ,sortlistsort);
};

</script>

<template>
<div class="change-sort-model" v-show="sortOpen">
    <div class="back"></div>
    <div class="content">
      <div class="model-header">
        <svg xmlns="http://www.w3.org/2000/svg" @click="emit('closeSortModel', false);" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </div>
      <div class="model-list">
        <p>請拖曳物件決定順序(由上至下)。</p>
        <ul class="sortable-list" ref="sortableList" @dragover="initSortTableList">
          <li class="item" 
              v-for="(item, idx) of sortlist"
              :key="item.id"
              :data-id="item.id"
              draggable="true"
              @dragstart="changeSortStart(item.id, $event)"
              @dragend="changeSortEnd(item.id, $event)"
              >
            <div class="details">
              <img v-if="item.image_url" :src="item.image_url" />
                <img v-else src="@/assets/news.jpg" />
              <span>{{ item.name }} </span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
          </li>
        </ul>
        <button class="btn" @click="changeSortChk()" :disabled="sortLoading">
          <svg
              class="animate-spin h-5 w-5 text-gray-500"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              v-if="sortLoading"
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
            <span v-if="!sortLoading">變更</span>
        </button>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.change-sort-model{
  position: fixed;
  top: 0;
  left:0;
  width: 100%;
  height: 100vh;
  z-index: 999;
  display: flex;
  justify-content: center;
  align-items: center;
  >.back{
    position: absolute;
    top: 0;
    left:0;
    width: 100%;
    height: 100%;
    background-color: rgba($color: #000000, $alpha: .3);
  }
  >.content{
    position: relative;
    width: 100%;
    max-width: 600px;
    border-radius: 8px;
    overflow: hidden;
    >.model-header{
      width: 100%;
      background-color: #0074B4;
      padding: 10px;
      >svg{
        color:#fff;
        margin-left:auto;
        cursor: pointer;
      }
    }
    >.model-list{
      background-color: #fff;
      padding:20px;
      p{
        font-size: 13px;
        margin-bottom: 10px;
      }
      .item{
        border: 1px #ddd solid;
        margin-bottom: 10px;
        border-radius: 6px;
        padding: 8px;
        display: flex;
        align-items: center;
        cursor: move;
        >.details{
          display: flex;
          align-items: center;
          > img{
            width:60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 30px;
          }
          > span{
            font-size: 14px;
            display: block;
            width: 300px;
          }
        }
        >svg{
          margin-left: auto;
        }

      }
      >.btn{
        background-color: #0074B4;
        color:#fff;
        width: 120px;
        padding: 8px;
        font-size: 13px;
        border-radius: 7px;
        border:1px #0074B4 solid;
        transition: .3s;
        margin-top:20px;
        margin-left: auto;
        display:flex;
        justify-content:center;
        align-items:center;
        svg{
          color:#fff;
        }
        &:hover{
          background-color: #015988;
        }

        
      }
    }
  }
}
</style>