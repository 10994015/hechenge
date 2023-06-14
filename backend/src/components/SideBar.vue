<script setup>
import { computed, ref, watch } from "vue";
import CloseText from "./Shared/CloseText.vue";

const props = defineProps({
  modelValue: Boolean,
});
const emit = defineEmits(["openSideBar"]);
const isArticle = ref(false);
const isCourse = ref(false);
const isTeacher = ref(false);
const sideBarOpen = computed(() => props.modelValue);
const closeItems = () => {
  isCourse.value = false;
  isArticle.value = false;
  isTeacher.value = false;
};
watch(sideBarOpen, (val) => {
  if (val) {
    closeItems();
  }
});
const olObj = ref({
  article:[
    {
      link:'app.articles',
      textname:'文章列表',
    },
    {
      link:'app.article.categories',
      textname:'文章分類',
    },
  ],
  course:[
    {
      link:'app.courses',
      textname:'國高中課程'
    },
    {
      link:'app.course.tags',
      textname:'課程標籤'
    },
    {
      link:'app.course.categories',
      textname:'課程類別'
    },
  ],
  teacher:[
    {
      link:'app.teachers',
      textname:'師資列表'
    },
    {
      link:'app.teacher.categories',
      textname:'師資科目'
    }
  ]
})
const openList = (name) => {
  emit("openSideBar");
  if (name === "article") return (isArticle.value = !isArticle.value);
  if (name === "course") return (isCourse.value = !isCourse.value);
  if (name === "teacher") return (isTeacher.value = !isTeacher.value);
};
</script>

<template>
  <div :class="['sideBar', { close: sideBarOpen }]">
    <ul>
      <router-link :to="{ name: 'app.dashboard' }">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        <CloseText textName="首頁" v-model="sideBarOpen" />
      </router-link>

      <a href="javascript:;" @click="openList('article')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"
          />
        </svg>
        <CloseText textName="最新消息" v-model="sideBarOpen" />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          :class="['w-3', 'h-3', 'ml-auto', { active: isArticle }]"
          v-show="!sideBarOpen"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </a>
      <ol :style="{height: isArticle ? olObj.article.length * 48.5 + 'px' : 0 }">
        <router-link  v-for="ol in olObj.article" :key="ol.textname"  :to="{ name: ol.link }">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-3 h-3"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
          </svg>

          <CloseText :textName="ol.textname" v-model="sideBarOpen" />
        </router-link>
      </ol>


      <router-link :to="{ name: 'app.banners' }">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
          />
        </svg>

        <CloseText textName="首頁輪播圖" v-model="sideBarOpen" />
      </router-link>
      <a href="javascript:;" @click="openList('course')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
        </svg>
        <CloseText textName="課程介紹" v-model="sideBarOpen" />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          :class="['w-3', 'h-3', 'ml-auto', { active: isCourse }]"
          v-show="!sideBarOpen"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </a>
      <ol :style="{height: isCourse ? olObj.course.length * 48.5 + 'px' : 0 }">
        <router-link v-for="ol in olObj.course" :key="ol.textname" :to="{ name: ol.link }">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-3 h-3"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
          </svg>

          <CloseText :textName="ol.textname" v-model="sideBarOpen" />
        </router-link>
      </ol>
      <a href="javascript:;" @click="openList('teacher')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
        </svg>
        <CloseText textName="師資介紹" v-model="sideBarOpen" />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          :class="['w-3', 'h-3', 'ml-auto', { active: isCourse }]"
          v-show="!sideBarOpen"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </a>
      <ol :style="{height: isTeacher ? olObj.teacher.length * 48.5 + 'px' : 0 }">
        <router-link v-for="ol in olObj.teacher" :key="ol.textname" :to="{ name: ol.link }">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-3 h-3"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
          </svg>

          <CloseText :textName="ol.textname" v-model="sideBarOpen" />
        </router-link>
      </ol>
      <router-link :to="{ name: 'app.students' }">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
      </svg>
        <CloseText textName="學生回饋" v-model="sideBarOpen" />
      </router-link>
      <router-link :to="{ name: 'app.faqs' }">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
        </svg>
        <CloseText textName="常見問答" v-model="sideBarOpen" />
      </router-link>
    </ul>
  </div>
</template>

<style lang="scss" scoped>
.sideBar {
  min-width: 250px;
  width: 250px;
  min-height: calc(100vh - 80px);
  height: auto;
  background-color: #fff;
  padding: 20px 10px;
  transition: 0.3s;
  color:#111;
  box-shadow: 0 8px 5px #ccc;
  &.close {
    width: 90px;
    min-width: 90px;
  }
 
  > ul {
    margin-top: 10px;
    a {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      margin-bottom: 6px;
      padding: 12px 25px;
      border-radius: 25px;
      transition: 0.3s;
      &:hover {
        // background-color: rgba($color: #000, $alpha: 0.3);
        color: #1484c4;
      }
      &.active {
        color: #fff;
      }
      svg {
        margin-right: 10px;
        min-width: 20px;
        width: 20px;
      }
    }
    ol {
      margin-left: 10px;
      height: 0;
      overflow: hidden;
      transition: .3s;
      &.open {
        height: auto;
      }
      > a {
        border-radius: 0;
        padding: 10px 15px;
      }
    }
    svg.active {
      transform: rotate(180deg);
    }
  }
}
</style>
