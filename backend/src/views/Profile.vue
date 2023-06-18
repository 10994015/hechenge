<script setup>
import { ref, onMounted,  } from 'vue';
import store from '../store';
const loading = ref(true)
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
});

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
                <router-link :to="{name: 'app.inbox'}">訊息</router-link>

            </div>
        </div>
        <div class="nav">
            <router-link :to="{ name:'app.profile.manager' }" class="active">管理者資料</router-link>
            <router-link :to="{ name:'app.profile.activity-log' }">活動日誌</router-link>
        </div>
        <router-view @updateProfile='getProfile'></router-view>
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
    background-image: url('@/assets/images/profilebanner3.jpg');
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
            &.router-link-exact-active{
                color:#1c84ee;
                border-bottom: 1px #1c84ee solid;
            }
        }
    }
    
  }
  
}
</style>