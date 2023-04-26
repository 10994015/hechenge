<script setup>
import { computed, ref, watch } from "vue";
import CloseText from "./Shared/CloseText.vue";

const props = defineProps({
  modelValue: Boolean,
});
const emit = defineEmits(["openSideBar"]);
const isAbout = ref(false);
const isAwards = ref(false);
const isInfo = ref(false);
const sideBarOpen = computed(() => props.modelValue);
const closeItems = () => {
  isAbout.value = false;
  isAwards.value = false;
  isInfo.value = false;
};
watch(sideBarOpen, (val) => {
  if (val) {
    closeItems();
  }
});
const openList = (name) => {
  emit("openSideBar");
  if (name === "about") return (isAbout.value = !isAbout.value);
  if (name === "awards") return (isAwards.value = !isAwards.value);
  if (name === "info") return (isInfo.value = !isInfo.value);
};
</script>

<template>
  <div :class="['sideBar', { close: sideBarOpen }]">
    <ul>
      <router-link :to="{ name: 'app.dashboard' }">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"
          />
        </svg>
        <CloseText textName="首頁" v-model="sideBarOpen" />
      </router-link>
      <router-link :to="{ name: 'app.news' }">
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
            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
          />
        </svg>
        <CloseText textName="最新消息" v-model="sideBarOpen" />
      </router-link>
      <router-link :to="{ name: 'app.dashboard' }">
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
        border-bottom: 1px #ddd solid;
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
