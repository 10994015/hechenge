<script setup>
import { computed, ref, watch } from "vue";
import CloseText from "./Shared/CloseText.vue";

const props = defineProps({
  modelValue: Boolean,
});
const emit = defineEmits(["openSideBar"]);
const isArticle = ref(false);
const isAbout = ref(false);
const sideBarOpen = computed(() => props.modelValue);
const closeItems = () => {
  isAbout.value = false;
  isArticle.value = false;
};
watch(sideBarOpen, (val) => {
  if (val) {
    closeItems();
  }
});
const openList = (name) => {
  emit("openSideBar");
  if (name === "article") return (isArticle.value = !isArticle.value);
  if (name === "about") return (isAbout.value = !isAbout.value);
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
      <ol :class="{ open: isArticle }">
        <router-link :to="{ name: 'app.articles' }">
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

          <CloseText textName="文章列表" v-model="sideBarOpen" />
        </router-link>
        <router-link :to="{ name: 'app.article.categories' }">
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

          <CloseText textName="文章分類" v-model="sideBarOpen" />
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
      <a href="javascript:;" @click="openList('about')">
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
        <CloseText textName="關於學會" v-model="sideBarOpen" />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          :class="['w-3', 'h-3', 'ml-auto', { active: isAbout }]"
          v-show="!sideBarOpen"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </a>
      <ol :class="{ open: isAbout }">
        <router-link :to="{ name: 'app.dashboard' }">
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

          <CloseText textName="理事長的話" v-model="sideBarOpen" />
        </router-link>
      </ol>
     
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
