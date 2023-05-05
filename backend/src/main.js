import { createApp } from 'vue'
import stroe from "./store"
import router from "./router"
import './index.css'
import CKEditor from '@ckeditor/ckeditor5-vue'

import App from './App.vue'

createApp(App).use(stroe).use(CKEditor).use(router).mount('#app')
