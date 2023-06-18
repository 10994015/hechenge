<script setup>
import { ref, onMounted, computed } from "vue";
import store from "../store";
import Loading from "./Loading.vue";
import Sidebar from "./SideBar.vue";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
const sideBarOpen = ref(false);
onMounted(() => {
  store.dispatch("getUser");
});
const currentUser = computed(() => store.state.user.data);
const toggleSideBar = () => {
  sideBarOpen.value = !sideBarOpen.value;
};
const openSideBar = () => {
  sideBarOpen.value = false;
};
</script>

<template>
  <div class="app" v-if="currentUser.id">
    <Header @openSideBar="toggleSideBar" :userName="currentUser.name" :sideBarOpen="sideBarOpen" :image="currentUser.image_url" />
    <div class="main">
        <Sidebar v-model="sideBarOpen" @openSideBar="openSideBar" />
        <main>
            <div class="router-view">
                <router-view></router-view>
            </div>
            <Footer text="赫成教育" />
        </main>
    </div>
  </div>
  <div class="loading" v-else>
    <Loading />
    <span>LOADING...</span>
  </div>
</template>

<style lang="scss" scoped>
.loading {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: #F4F5F8;
  width: 100%;
  height: 100vh;
  span {
    color: #333;
    margin-top: 20px;
    letter-spacing: 2.6px;
  }
}
.app {
  width: 100%;
  min-height: 100vh;
  height: 100%;
  background-color: #F4F5F8;
  color: #111;
  display: flex;
  flex-direction: column;
  > .main {
    width: 100%;
    height: auto;
    min-height: calc(100vh - 80px);
    display: flex;
    > main {
      height: auto;
      width: 100%;
      >.router-view{
        height: auto;
        min-height: calc(100vh - 151px);
      }
    }
  }
}
</style>
