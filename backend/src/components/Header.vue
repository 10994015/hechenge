<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { computed } from "vue";
import { useRouter } from "vue-router";
import store from "../store";
import CloseText from "./Shared/CloseText.vue";

const props = defineProps({
  userName: String,
  sideBarOpen:Boolean,
});
const userName = computed(() => props.userName);
const sideBarOpen = computed(()=>props.sideBarOpen)
const router = useRouter();
const emit = defineEmits(["openSideBar"]);

const logout = () => {
  store.dispatch("logout").then(() => {
    router.push({ name: "login" });
  });
};

</script>

<template>
  <header>
    <div class="left">
        <router-link to="/" class="logo">
            <img src="@/assets/images/logo-sm.svg" />
            <CloseText textName="赫成教育" v-model="sideBarOpen" />
        </router-link>
      <svg
        @click="emit('openSideBar')"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        :class="['w-6', 'h-6', {'close':sideBarOpen}]"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
        />
      </svg>
    
    </div>
    <Menu as="div" class="relative inline-block text-left">
      <div class="mt-2">
        <MenuButton class="flex items-center">
          <img src="@/assets/images/hea.jpg" class="rounded-full w-10 mr-2" />
          <p class="text-sm">{{ userName }}</p>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-4 w-4 ml-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 8.25l-7.5 7.5-7.5-7.5"
            />
          </svg>
        </MenuButton>
      </div>

      <transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <MenuItems
          class="absolute right-0 mt-2 w-36 origin-top-right divide-y divide-gray-100 rounded-sm bg-[#fff] shadow-lg ring-1 ring-white ring-opacity-5 focus:outline-none"
        >
          <div class="px-1 py-1">
            <MenuItem v-slot="{ active }">
              <button
                @click="router.push({ name: 'app.profile' })"
                :class="[
                  active ? 'bg-[#fff]-600 text-[#111]' : 'text-[#111]',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-[#f1f1f1] hover:text-[#333]',
                ]"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-4 h-4 mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25"
                  />
                </svg>
                Profile
              </button>
            </MenuItem>
            <MenuItem v-slot="{ active }">
              <button
                @click="logout()"
                :class="[
                  active ? 'bg-[#fff] text-[#111]' : 'text-[#111]',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-[#f1f1f1] hover:text-[#333]',
                ]"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-4 h-4 mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"
                  />
                </svg>
                Logout
              </button>
            </MenuItem>
          </div>
        </MenuItems>
      </transition>
    </Menu>
  </header>
</template>

<style lang="scss" scoped>
header {
  background-color: #0074B4;
  padding: 10px 50px 10px 20px;
  display: flex;
  justify-content: space-between;
  color:#fff;
  > .left {
    display: flex;
    justify-content: center;
    align-items: center;
    > .logo {
        display: flex;
        align-items: center;
        font-size: 22px;
        color: #fff;
        font-weight: 900;
        padding: 12px;
        transition: .3s;
        > img {
        color: #ff9898;
        margin-right: 5px;
        min-width: 30px;
        width: 30px;
        }
        > span {
        letter-spacing: 1.6px;
        font-size: 21px;
        transition: 0.3s;
       
        &:hover {
            color: #bbb;
        }
      }
  }
    > svg {
      color: #fff;
      cursor: pointer;
      margin-left: 100px;
      transition: all .3s ease;
      &.close{
            margin-left:20px;
        }
    }
    > .form-group {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      > input {
        background-color: #2f373f;
        width: 190px;
        color: #ddd;
        height: 40px;
        padding: 0 12px;
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
        outline: none;
        border: none;
      }
      > button {
        cursor: pointer;
        color: #fff;
        background-color: #1c84ee;
        width: 40px;
        height: 40px;
        text-align: center;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
        svg {
          color: #fff;
          padding: 0;
          margin: 0;
          display: inline;
        }
      }
    }
  }
}
</style>
