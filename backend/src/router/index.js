import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue"
import Dashboard from "../views/Dashboard.vue"
import News from "../views/News.vue"
import NotFound from "../views/NotFound.vue"
import AppLayout from "../components/AppLayout.vue"
import store from "../store"
const routes = [
    {
        path:'/',
        name: 'app',
        component: AppLayout,
        meta:{
            requiresAuth:true,
        },
        children:[
            {
                path:'',
                name:'app.dashboard',
                component: Dashboard
            },
            {
                path:'/news',
                name:'app.news',
                component: News
            },
        ]
    },
    {
        path:'/login',
        name: 'login',
        component: Login,
        meta:{
            requiresGuest:true
        }
    },
    {
        path:'/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})
router.beforeEach((to, from, next)=>{
    if(to.meta.requiresAuth && !store.state.user.token){
        next({name:'login'})
    }else if(to.meta.requiresGuest && store.state.user.token){
        next({name:'app.dashboard'});
    }else{
        next();
    }
})
export default router