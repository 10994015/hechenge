import { createApp } from 'vue'
import stroe from "./store"
import router from "./router"
import './index.css'
import CKEditor from '@ckeditor/ckeditor5-vue'

import App from './App.vue'

const app = createApp(App)

app.directive("run", {
    mounted(el){
        let num = Number(el.innerText);
        let current = 0;
        let timer = null
        el.innerHTML = 0;
        timer = setInterval(()=>{
            if(current >= num){
                clearInterval(timer)
            }
            current++;
            el.innerHTML = current
        }, 300/num )
    }
})

app.use(stroe).use(CKEditor).use(router).mount('#app')
