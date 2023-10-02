<script setup>
import { ref, onMounted, } from "vue";
import store from "../store";
import { useRouter, useRoute } from "vue-router";
const route = useRoute();
const router = useRouter();
const DEFAULT_TEACHER = {
  id: "",
  name:"",
  subname:"",
  image: "",
  title1: "",
  content1: "",
  title2: "",
  content2: "",
  title3: "",
  content3: "",
  title4: "",
  content4: "",
  title5: "",
  content5: "",
  category_id: 1,
  hidden: false,
};
const image_url = ref("");
const categories = ref([]);
const categoryLoading = ref(true)
const randerLoading = ref(false);

const loading = ref(false);
const previewLoading = ref(false);
const previewImg = ref(null);
const isPreview = ref(false);
const errorMsg = ref(null);
const successMsg = ref(null);
const teacher = ref({ ...DEFAULT_TEACHER });
const isCreate = ref(false);
const successMsgSetNull = ()=>{
  successMsg.value = null;
}
onMounted(() => {
  
  const teacherId = route.params.id;

  store.dispatch('getTeacherCategories',
  {
      url:null,
    }
  ).then(res=>{
    categories.value = store.state.teacherCategories.data
    categoryLoading.value = store.state.teacherCategories.loading
    teacher.value.category_id = categories.value[0].id
  })

  if (teacherId === "create") {
    randerLoading.value = true;
    teacher.value.id = teacherId;
    isCreate.value = true;
    
    return;
  }
  store
    .dispatch("isExistTeacher", teacherId)
    .then((res) => {
      if (res.data) {
        store
          .dispatch("getTeacher", teacherId)
          .then((res) => {
            teacher.value = res.data;
            image_url.value = res.data.image_url;
            if (image_url.value) {
              isPreview.value = true;
            }
            randerLoading.value = true;

            teacher.value.title =
              teacher.value.title == "null" ? "" : teacher.value.title;
            teacher.value.content =
              teacher.value.content == "null" ? "" : teacher.value.content;
          })
          .then(() => {
            if (image_url.value != "") {
              previewImg.value.src = image_url.value;
            }
          });
      } else {
        router.push({ path: "/notfound" });
      }
    })
    .catch((err) => {
      console.error(err);
    });



  
});

const previewImage = (ev) => {
  previewLoading.value = true;
  successMsgSetNull()
  if (ev.target.files && ev.target.files[0]) {
    teacher.value.image = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImg.value.src = e.target.result;
    };
    reader.readAsDataURL(ev.target.files[0]);
  }
  previewLoading.value = false;
  isPreview.value = true;
};
const onSubmit = () => {
  loading.value = true;
  if (isCreate.value) {
    store
      .dispatch("createTeacher", teacher.value)
      .then((res) => {
        if (res.status === 200 || res.status === 201) {
          successMsg.value = "上傳成功！";
          errorMsg.value = null;
        }
        loading.value = false;
      })
      .catch((err) => {
        loading.value = false;
        errorMsg.value = err.response.data.errors;
      });
  } else {
    store
      .dispatch("updateTeacher", teacher.value)
      .then((res) => {
        if (res.status === 200 || res.status === 201) {
          successMsg.value = "更新成功！";
          errorMsg.value = null;
        }
        loading.value = false;
      })
      .catch((err) => {
        loading.value = false;
        errorMsg.value = err.response.data.errors;
      });
  }
};


</script>

<template>
  <div class="addTeacher">
    <h1 v-if="isCreate">新增師資</h1>
    <h1 v-else>編輯師資</h1>
    <div class="card">
      <div class="card-title">
        <h2>Basic Information</h2>
      </div>
      <form v-if="randerLoading" action="" @submit.prevent="onSubmit()">
        <div class="form-group">
          <label for="">科目</label>
          <div class="container">
            <select v-if="categoryLoading" disabled>
            <option value="">Loading...</option>
            </select>
            <select v-else v-model="teacher.category_id" @change="successMsgSetNull()">
              <option v-for="category in categories" :key="category.id"  :value="category.id">{{category.name}}</option>
            </select>
            <router-link :to="{name:'app.teacher.add-category' , params: { id: 'create' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
            </router-link>
          </div>
        </div>
        <div class="form-group">
          <label for=""><span class="text-red-800">*</span>教師姓名</label>
          <input type="text" v-model="teacher.name" @keyup="successMsgSetNull()" />
        </div>
        <div class="form-group">
          <label for="">教師頭銜</label>
          <input type="text" v-model="teacher.subname" @keyup="successMsgSetNull()" />
        </div>
        <div class="form-group">
          <label for="">教師照片</label>
          <label for="imagefile" class="imagefileFor">
            <svg
              v-if="previewLoading"
              class="animate-spin h-5 w-5 text-gray-500"
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
            <div v-if="!isPreview">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5 mb-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"
                />
              </svg>
              <span>將文件拖放到此處或單擊以上傳。</span>
            </div>
            <div v-else class="isPreview">
              <img src="" ref="previewImg" id="previewImg" />
            </div>
          </label>
          <input type="file" id="imagefile" hidden @change="previewImage($event)" />
        </div>
        <div class="form-group title-content-group">
          <label for="">標題1</label>
          <input type="text" v-model="teacher.title1" placeholder="(學經歷)" @keyup="successMsgSetNull()" />
          <label for="" class="mt-2">內容1</label>
          <textarea  v-model="teacher.content1" @keyup="successMsgSetNull()"></textarea>
        </div>
        <div class="form-group title-content-group">
          <label for="">標題2</label>
          <input type="text" v-model="teacher.title2" placeholder="(教學理念)" @keyup="successMsgSetNull()" />
          <label for="" class="mt-2">內容2</label>
          <textarea  v-model="teacher.content2" @keyup="successMsgSetNull()"></textarea>
        </div>
        <div class="form-group title-content-group">
          <label for="">標題3</label>
          <input type="text" v-model="teacher.title3" placeholder="(教學特色)" @keyup="successMsgSetNull()" />
          <label for="" class="mt-2">內容3</label>
          <textarea  v-model="teacher.content3" @keyup="successMsgSetNull()"></textarea>
        </div>
        <div class="form-group title-content-group">
          <label for="">標題4</label>
          <input type="text" v-model="teacher.title4" placeholder="(教學特色)" @keyup="successMsgSetNull()" />
          <label for="" class="mt-2">內容4</label>
          <textarea  v-model="teacher.content4" @keyup="successMsgSetNull()"></textarea>
        </div>
        <div class="form-group title-content-group">
          <label for="">標題5</label>
          <input type="text" v-model="teacher.title5" placeholder="(其他)" @keyup="successMsgSetNull()" />
          <label for="" class="mt-2">內容5</label>
          <textarea  v-model="teacher.content5" @keyup="successMsgSetNull()"></textarea>
        </div>
        
        <div class="chkbox-group">
          <div class="form-group">
            <label for="">隱藏教師</label>
            <input type="checkbox" v-model="teacher.hidden" @change="successMsgSetNull()" />
          </div>
        </div>
        <span v-if="successMsg" class="successMsg">{{ successMsg }}</span>
        <div class="form-group btn-group mt-10">
          <button type="submit" :class="{ loading: loading }">
            <svg
              v-if="loading"
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
          <button
            class="pre"
            type="button"
            @click="router.push({ name: 'app.teachers' })"
          >
            回列表
          </button>
        </div>
      </form>
      <div v-else class="flex items-center justify-center py-10">
        <svg
          class="animate-spin h-5 w-5 text-gray-500"
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
      <div class="errorMsg" v-if="errorMsg">
        <span v-for="(error, i) in errorMsg" :key="i"> {{ error[0] }}</span>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.addTeacher {
  display: flex;
  flex-direction: column;
  padding: 20px 25px;

  > h1 {
    font-weight: 900;
    color: #333;
  }
  > .card {
    background-color: #fff;
    border-radius: 12px;
    padding: 1.5rem 4rem 1.5rem 2.5rem;
    margin-top: 25px;
    > .card-title {
      border-bottom: 1px #aaa solid;
      padding-bottom: 25px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      h2 {
        color: #333;
        font-size: 17px;
        font-weight: 800;
      }
      p {
        margin-top: 5px;
        margin-bottom: 15px;
      }
      > .categoryBtn {
        margin-left: auto;
        button {
          background-color: #1c84ee;
          color: #fff;
          border-radius: 25px;
          padding: 10px 23px;
          transition: 0.3s;
          font-size: 13px;
          margin-left: 16px;
          &:hover {
            background-color: #1870ca;
            border-color: #1870ca;
          }
          > i {
            margin-right: 3px;
          }
        }
      }
    }
    > form {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(1, 100%);
      grid-column-gap: 30px;
      .chkbox-group {
        display: flex;
        justify-content: flex-start;
        align-items: center;
      }
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
      .form-group {
        display: flex;
        flex-direction: column;
        padding: 12px 0;
        &.title-content-group{
            padding: 18px 12px;
            border-radius: 6px;
            background-color: rgba(214, 243, 233, .25);
            margin-bottom: 10px;
        }
        &.btn-group {
          flex-direction: row;
        }
        >.container{
          display: flex;
          align-items: center;
          >select{
            width: calc(100% - 46px);
            margin-right: 10px;
          }
          >a{
            display: flex;
            background-color: #34C38F;
            color:#fff;
            width: 36px;
            height: 36px;
            border-radius: 5px;
            justify-content: center;
            align-items: center;
          }
        }
        > label {
          margin-bottom: 10px;
          font-weight: 900;
          font-size: 13px;
          color: #333;
        }
        > .imagefileFor {
          width: 100%;
          height: 140px;
          background-color: #fff;
          border: 2px #aaa dashed;
          cursor: pointer;
          > div {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 15px;
            position: relative;
            width: 100%;
            height: 100%;
            &.isPreview > svg {
              position: absolute;
              top: 8px;
              right: 15px;
              color: #111;
              cursor: pointer;
            }
            > img {
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              height: 100%;
              object-fit: contain;
            }
          }
        }
        input[type="text"],
        input[type="number"],
        select {
          border: none;
          outline: none;
          border-radius: 5px;
          padding: 0 12px;
          background-color: #fff;
          color: #111;
          border: 1px #aaa solid;
          height: 36px;
          font-size: 14px;
        }
        > .input-group {
          display: flex;
          align-items: center;
          width: 100%;
          .icon {
            background-color: hsla(0, 0%, 100%, 0.1);
            width: 36px;
            height: 36px;
            border: none;
            padding: 7.5px 0 7.5px 9px;
            border-radius: 5px 0 0 5px;
            margin-right: 0;
          }

          input {
            margin-left: 0;
            width: calc(100% - 36px);
          }
        }
        > textarea {
          border: none;
          outline: none;
          border-radius: 5px;
          padding: 8px 12px;
          background-color: #fff;
          color: #111;
          border: 1px #aaa solid;
          height: 140px;
          font-size: 14px;
          resize: none;
          resize: vertical;
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
    }
    > .errorMsg {
      display: flex;
      flex-direction: column;
      > span {
        color: rgb(180, 0, 0);
        margin-top: 4px;
      }
    }
  }
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield; /* Firefox */
}

input[type="checkbox"],
input[type="radio"] {
  position: relative;
  width: 50px;
  height: 25px;
  outline: none;
  background: linear-gradient(to right, #bbb, #999);
  -webkit-appearance: none;
  cursor: pointer;
  border-radius: 20px;
  &::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 25px;
    height: 25px;
    background: #fff;
    border-radius: 50%;
    transform: scale(0.98, 0.96);
    transition: 0.5s;
  }
  &:checked {
    background: linear-gradient(to right, #1c84ee, #185cc9);
    &::before {
      left: 25px;
    }
  }
  &::after {
    content: "";
  }
}
</style>
