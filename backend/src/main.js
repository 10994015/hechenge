import { createApp } from 'vue'
import stroe from "./store"
import router from "./router"
import './index.css'
import App from './App.vue'

createApp(App).use(stroe).use(router).mount('#app')
