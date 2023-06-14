import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue"
import Dashboard from "../views/Dashboard.vue"
import Profile from "../views/Profile.vue"
import Articles from "../views/Articles.vue"
import AddArticle from "../views/AddArticle.vue"
import ArticleCategories from "../views/ArticleCategories.vue"
import AddArticleCategory from "../views/AddArticleCategory.vue"
import CourseCategories from "../views/CourseCategories.vue"
import AddCourseCategory from "../views/AddCourseCategory.vue"
import CourseTags from "../views/CourseTags.vue"
import AddCourseTag from "../views/AddCourseTag.vue"
import Banners from "../views/Banners.vue"
import AddBanner from "../views/AddBanner.vue"
import Courses from "../views/Courses.vue"
import AddCourse from "../views/AddCourse.vue"
import Teachers from "../views/Teachers.vue"
import AddTeacher from "../views/AddTeacher.vue"
import TeacherCategories from "../views/TeacherCategories.vue"
import AddTeacherCategory from "../views/AddTeacherCategory.vue"
import Students from "../views/Students.vue"
import AddStudent from "../views/AddStudent.vue"
import Faqs from "../views/Faqs.vue"
import AddFaq from "../views/AddFaq.vue"
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
                path:'profile',
                name:'app.profile',
                component: Profile
            },
            {
                path:'articles',
                name:'app.articles',
                component: Articles
            },
            {
                path:'add-articles/:id',
                name:'app.add-article',
                component:AddArticle,
            },
            {
                path:'/article-categories',
                name:'app.article.categories',
                component: ArticleCategories
            },
            {
                path:'add-article-category/:id',
                name:'app.article.add-category',
                component:AddArticleCategory,
            },
            {
                path:'banners',
                name:'app.banners',
                component:Banners,
            },
            {
                path:'add-banner/:id',
                name:'app.add-banner',
                component:AddBanner,
            },
            {
                path:'courses',
                name:'app.courses',
                component:Courses,
            },
            {
                path:'add-course/:id',
                name:'app.add-course',
                component:AddCourse,
            },
            {
                path:'/course-categories',
                name:'app.course.categories',
                component: CourseCategories
            },
            {
                path:'add-course-category/:id',
                name:'app.course.add-category',
                component:AddCourseCategory,
            },
            {
                path:'/course-tags',
                name:'app.course.tags',
                component: CourseTags
            },
            {
                path:'add-course-tag/:id',
                name:'app.course.add-tag',
                component:AddCourseTag,
            },
            {
                path:'/teachers',
                name:'app.teachers',
                component: Teachers
            },
            {
                path:'add-teacher/:id',
                name:'app.add-teacher',
                component:AddTeacher,
            },
            {
                path:'/teacher-categories',
                name:'app.teacher.categories',
                component: TeacherCategories
            },
            {
                path:'add-teacher-category/:id',
                name:'app.teacher.add-category',
                component:AddTeacherCategory,
            },
            {
                path:'/students',
                name:'app.students',
                component: Students
            },
            {
                path:'add-student/:id',
                name:'app.add-student',
                component:AddStudent,
            },
            {
                path:'/faqs',
                name:'app.faqs',
                component: Faqs
            },
            {
                path:'add-faq/:id',
                name:'app.add-faq',
                component:AddFaq,
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