<script setup>
import { ref, onMounted } from 'vue';
import store from '../store';

const headOverlay = ref(false);
const loading = ref(true)
const storeLoading = ref(false)
const previewImg = ref(null);
const previewLoading = ref(false);
const isPreview = ref(false);
const image_url = ref("");
const DEFAULT_PROFILE = {
  id: "",
  name: "",
  image: "",
  username:"",
};
const profile = ref({ ...DEFAULT_PROFILE });
const getProfile = ()=>{
    loading.value = true
    store.dispatch('getUser').then(res=>{
        profile.value.name = res.data.name
        profile.value.username = res.data.username
        profile.value.id = res.data.id
        image_url.value = res.data.image_url;
        if (image_url.value) {
            isPreview.value = true;
        }
        loading.value = false
    })
}
onMounted(() => {
    getProfile()
})
const previewImage = (ev) => {
  previewLoading.value = true;
  if (ev.target.files && ev.target.files[0]) {
    profile.value.image = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImg.value.src = e.target.result;
    };
    reader.readAsDataURL(ev.target.files[0]);
  }
  previewLoading.value = false;
  isPreview.value = true;
};
const onSubmit = ()=>{
    storeLoading.value = true
    store.dispatch('updateUser', profile.value).then(res=>{
        getProfile()
        storeLoading.value = false
    })
    
};

</script>

<template> 
<div class="profile">
    <div class="banner">
        <div class="overlay"></div>
    </div>
    <div class="main">
        <div class="info">
            <div class="left">
                <div class="head">
                    <img :src="image_url" alt="">
                </div>
                <div class="data">
                    <h3>{{profile.name}}</h3>
                    <p>赫成教育</p>
                </div>
            </div>
            <div class="right">
                <router-link to="{{ route('name:app.dashboard') }}">訊息</router-link>

            </div>
        </div>
        <div class="nav">
            <router-link :to="{ name:'app.profile' }" class="active">管理者資料</router-link>
            <router-link :to="{ name:'app.dashboard' }">活動日誌</router-link>
        </div>
        <div class="card loading" v-if="loading">
            <svg
                class="animate-spin h-5 w-5 text-gray-900"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
                ></circle>
                <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
            </svg>
        </div>
        <div class="card" v-else>
            <div class="profile-info">
                <form @submit.prevent="onSubmit()">
                    <div class="form-group headimg">
                        <label for="headimg">
                            <div class="imgbox" @mouseover="headOverlay=true" @mouseout="headOverlay=false">
                                <img :src="image_url" ref="previewImg" id="previewImg" />
                                <div class="overlay" :class="{'open':headOverlay}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                        <input type="file" hidden id="headimg" @change="previewImage($event)" />
                    </div>
                    <div class="form-group">
                        <label for="">帳號</label>
                        <input type="text" disabled v-model="profile.username" class="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="">管理者名稱</label>
                        <input type="text"  v-model="profile.name" class="" />
                    </div>
                    <div class="form-group">
                        <router-link to="/dashoboard" class="change-password">更改密碼</router-link>
                    </div>
                    <div class="form-group">
                        <button type="submit" :class="{ 'loading': storeLoading }">
                            <svg
                                v-if="storeLoading"
                                class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            <span v-else>保存更改</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

.profile {
  display: flex;
  flex-direction: column;
  >.banner{
    width: 100%;
    height: 300px;
    background-image: url('@/assets/images/profilebanner.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    >.overlay{
        background-color: rgba($color: #000000, $alpha: .25);
        width: 100%;
        height: 100%;
    }
  }
    
  > h1 {
    font-weight: 900;
    color: #333;
  }
  >.main{
    padding: 0 25px;
    >.info{
        padding: 25px 0 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        border-bottom: 1px #ddd solid;
        >.left{
            display: flex;
            align-items: flex-start;
            >.head{
                width: 130px;
                height: 130px;
                border-radius: 50%;
                border:8px #fff solid;
                object-fit: cover;
                overflow: hidden;
                transform: translateY(-60px);
                margin-right: 30px;
                >img{
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
        }
        >.data{
            h3{
                font-weight: 700;
                font-size: 17px;
            }
            p{
                color:#666;
                font-size: 14px;
                margin-top: 5px;
            }
        }
        }
        >.right{
            padding-right:30px ;
            a{
                color: #f6f6f6;
                cursor: pointer;
                background-color: #34c38f;
                border-radius: 6px;
                display: block;
                padding: 10px 20px;
                text-align: center;
                font-weight: 900;
                font-size: 14px;
                transition: 0.3s;
                &:hover {
                    background-color: #2ca67a;
                }
            }
        }
    }
    >.nav{
        display: flex;
        align-items: center;
        a{
            color:#111;
            margin-right: 6px;
            padding: 20px 30px;
            transition: .3s;
            font-size: 14px;
            text-align: center;
            &:hover{
                color:#1c84ee;
            }
            &.active{
                color:#1c84ee;
                border-bottom: 1px #1c84ee solid;
            }
        }
    }
    > .card {
        background-color: #fff;
        border-radius: 12px;
        padding: 1.5rem 2.5rem;
        margin: 25px 0 50px;
        &.loading{
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:transparent;
        }
        >.profile-info{
            display: flex;
            flex-direction: column;
            > form {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(1, 100%);
                grid-column-gap: 30px;
                span.successMsg {
                    margin-top: 15px;
                    background-color: rgb(0, 190, 48);
                    color: #fff;
                    border-radius: 3px;
                    padding: 10px 20px;
                    font-size: 13px;
                    max-width: 120px;
                    text-align: center;
                }
                .form-group{
                    margin:10px 0;
                    &.headimg{
                        max-width: 150px;
                    }
                    label{
                        font-size: 14px;
                        color:#333;
                        width: 150px;
                    }
                    >a.change-password{
                        color: #f6f6f6;
                        cursor: pointer;
                        background-color: #ef6767;
                        border-radius: 6px;
                        display: block;
                        padding: 10px 20px;
                        text-align: center;
                        font-weight: 900;
                        font-size: 14px;
                        transition: 0.3s;
                        width: 120px;
                        float: right;
                        &:hover {
                            background-color: #f00;
                        }
                    }
                    input[type="text"],
                    input[type="number"]{
                        border: none;
                        outline: none;
                        border-radius: 5px;
                        padding: 0 12px;
                        background-color: #fff;
                        color: #111;
                        border: 1px #ddd solid;
                        height: 36px;
                        font-size: 14px;
                        width: 100%;
                        margin-top: 3px;
                        &.disabled{
                            background-color: #f1f1f1;
                            color:#555;
                            cursor: not-allowed;
                        }
                    }
                    > button,
                    .pre {
                        color: #f6f6f6;
                        background-color: #1c84ee;
                        border-color: #1c84ee;
                        border-radius: 5px;
                        height: 38px;
                        font-size: 13px;
                        font-weight: 500;
                        width: auto;
                        transition: 0.3s;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        padding: 0 20px;
                        &.loading {
                            cursor: not-allowed;
                            background-color: #1870ca;
                            border-color: #1870ca;
                        }
                        &:hover {
                            background-color: #1870ca;
                            border-color: #1870ca;
                        }
                        &.loading {
                            cursor: not-allowed;
                            background-color: #1870ca;
                            border-color: #1870ca;
                        }
                        > svg {
                            text-align: center;
                        }
                        }
                        .pre {
                            background-color: #74788d;
                            color: #f6f6f6;
                            margin-left: 10px;
                            &:hover {
                                background-color: #636678;
                                border-color: #5d6071;
                            }
                    }
                }
                .imgbox{
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    border:6px #ddd solid;
                    overflow: hidden;
                    position: relative;
                    >img{
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        cursor: pointer;
                    }
                    >.overlay{
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        background-color: rgba($color: #000000, $alpha: .5);
                        color:#aaa;
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        top: 0;
                        left:0;
                        cursor: pointer;
                        opacity: 0;
                        transition: .3s;
                        &.open{
                            opacity: 1;
                        }
                    }
                }
                
            }
        }
    }
  }
  
}
</style>