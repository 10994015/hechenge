import { createStore } from "vuex";
import * as actions from "./actions";
import * as mutations from "./mutations";

const store = createStore({
    state:{
        user:{
            token:sessionStorage.getItem('TOKEN'),
            data:{}
        },
        articles:{
            loading:false,
            data:[],
            links:[],
            from: null,
            to: null,
            page: 1,
            limit: null,
            total: null,
        },
        articleCategories:{
            loading:false,
            data:[],
            links:[],
            from: null,
            to: null,
            page: 1,
            limit: null,
            total: null,
        },
        banners:{
            loading:false,
            data:[],
            links:[],
            from: null,
            to: null,
            page: 1,
            limit: null,
            total: null,
        },
    },
    getters:{},
    actions,
    mutations,
})

export default store