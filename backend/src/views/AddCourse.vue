<script setup>
import { ref, onMounted, watch, } from "vue";
import store from "../store";
import { useRouter, useRoute } from "vue-router";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
const route = useRoute();
const router = useRouter();
const DEFAULT_COURSE = {
  id: "",
  title: "",
  image: "",
  content: "",
  grade:0,
  category_id: 1,
  hidden: false,
  focus: false,
  watched:0,
  visitor:0,
  is_full:false,
  tags:[],
};
const image_url = ref("");
const categories = ref([]);
const tags = ref([]);
const categoryLoading = ref(true)
const tagLoading = ref(true)
const randerLoading = ref(false);

const loading = ref(false);
const previewLoading = ref(false);
const previewImg = ref(null);
const isPreview = ref(false);
const errorMsg = ref(null);
const successMsg = ref(null);
const course = ref({ ...DEFAULT_COURSE });
const isCreate = ref(false);
const successMsgSetNull = ()=>{
  successMsg.value = null;
}
watch(()=>course.value.tags, (val)=>{
  console.log(val);
})
onMounted(() => {
  const courseId = route.params.id;
  getTags();

  if (courseId === "create") {
    randerLoading.value = true;
    course.value.id = courseId;
    isCreate.value = true;
    getCategories();
    return;
  }
  store
    .dispatch("isExistCourse", courseId)
    .then((res) => {
      if (res.data) {
        store
          .dispatch("getCourse", courseId)
          .then((res) => {
            course.value = res.data;
            image_url.value = res.data.image_url;
            if (image_url.value) {
              isPreview.value = true;
            }
            randerLoading.value = true;

            course.value.title =
              course.value.title == "null" ? "" : course.value.title;
            course.value.content =
              course.value.content == "null" ? "" : course.value.content;
          })
          .then(() => {
            getCategories(course.value.grade);
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
const getCategories = (grade=0)=>{
    categoryLoading.value =true
    successMsgSetNull()
    store.dispatch('getCourseCategories',
    {
        url:null,
        grade:grade,
        }
    ).then(res=>{
        categories.value = store.state.courseCategories.data
        if(categories.value.length > 0 ){
            course.value.category_id = categories.value[0].id
        }else{
            course.value.category_id = ''
        }
        categoryLoading.value = store.state.courseCategories.loading
    })
}
const getTags = ()=>{
    tagLoading.value = true
    store.dispatch('getCourseTags', {
        url:null,
    }).then(res=>{
        tags.value = store.state.courseTags.data
        tagLoading.value = store.state.courseTags.loading
    })
}
const previewImage = (ev) => {
  previewLoading.value = true;
  successMsgSetNull()
  if (ev.target.files && ev.target.files[0]) {
    course.value.image = ev.target.files[0];
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
      .dispatch("createCourse", course.value)
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
      .dispatch("updateCourse", course.value)
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
const editor = ref(ClassicEditor);

</script>

<template>
  <div class="addCourse">
    <h1 v-if="isCreate">新增課程</h1>
    <h1 v-else>編輯課程</h1>
    <div class="card">
      <div class="card-title">
        <h2>Basic Information</h2>
      </div>
      <form v-if="randerLoading" action="" @submit.prevent="onSubmit()">
        <div class="form-group">
          <label for="">年級</label>
          <div class="container">
            <select v-model="course.grade" @change="getCategories(course.grade)" >
                <option value="0">國中</option>
                <option value="1">高中</option>
                <option value="2">其他</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="">課程分類</label>
          <div class="container">
            <select v-if="categoryLoading" disabled class="categories">
            <option value="">Loading...</option>
            </select>
            <select v-else v-model="course.category_id" @change="successMsgSetNull()">
              <option v-for="category in categories" :key="category.id"  :value="category.id">{{category.name}}</option>
            </select>
            <router-link :to="{name:'app.course.add-category' , params: { id: 'create' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
            </router-link>
          </div>
        </div>
        <div class="form-group">
          <label for=""><span class="text-red-800">*</span>課程標題</label>
          <input type="text" v-model="course.title" @keyup="successMsgSetNull()" />
        </div>
        <div class="form-group">
          <label for=""><span class="text-red-800">*</span>課程內容</label>
          <ckeditor
            :editor="editor"
            id="editor"
            v-model="course.content"
            :config="{
              ckfinder: {
                uploadUrl: 'https://hechengschool.com/api/upload-images'
              },
            }"
          ></ckeditor>
          <!-- <textarea id="editor" name="editor" v-model="course.content"></textarea> -->
        </div>
        <div class="form-group">
          <label for="">課程封面</label>
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
        <div class="form-group">
          <label for=""><span class="text-red-800"></span>初始訪客人數</label>
          <input type="number" v-model="course.visitor" @keyup="successMsgSetNull()" />
        </div>
        <div class="form-group">
          <label for=""><span class="text-red-800"></span>初始點擊人數</label>
          <input type="number" v-model="course.watched" @keyup="successMsgSetNull()" />
        </div>
        <div class="chkbox-group">
          <div class="form-group">
            <label for="">隱藏課程</label>
            <input type="checkbox" class="slide" v-model="course.hidden" @change="successMsgSetNull()" />
          </div>
          <div class="form-group ml-10">
            <label for="">焦點課程</label>
            <input type="checkbox" class="slide" v-model="course.focus" @change="successMsgSetNull()" />
          </div>
          <div class="form-group ml-10">
            <label for="">是否額滿</label>
            <input type="checkbox" class="slide" v-model="course.is_full" @change="successMsgSetNull()" />
          </div>
        </div>
        <div class="form-group">
            <label for="" style="margin-bottom: 0;">課程標籤</label>
            <div class="chkbox-group p-5" v-if="tagLoading">
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
            <div class="chkbox-group mt-3" v-else>
                <div class="group" v-for="tag in tags" :key="tag.id">
                    <input type="checkbox" :id="'tag' + tag.id" :value="tag.id" v-model="course.tags" @change="successMsgSetNull()">
                    <label :for="'tag' + tag.id">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ tag.name }}
                    </label>
                </div>
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
            @click="router.push({ name: 'app.courses' })"
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
.addCourse {
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
        flex-wrap: wrap;
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
        &.btn-group {
          flex-direction: row;
        }
        &.tags{
            display: flex;
            flex-direction: row;
            align-items: center;
            >label{
                margin-bottom: 0;
                font-weight: 700;
                font-size: 16px;
                color: #444;
                margin-left: 2px;
            }
        }
        >.container{
          display: flex;
          align-items: center;
          >select{
            margin-right: 10px;
            width: 100%;
            &.categories{
                width: calc(100% - 46px);

            }
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

input[type="checkbox"].slide {
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
div.group{
    margin:3px 0;
    >input[type="checkbox"],input[type="radio"]{
        opacity: 0;
        display: none;
        transition: .2s;
        &:checked ~ label::before{
            transition: .2s;
            background-image: linear-gradient(to right, #34C38F , #21a574);
        }
        &:checked ~ label > svg{
            opacity: 1;
            transition: .2s;
            transform: scale(1);
        }
        
    }
    >label{
        display: flex;
        align-items: center;
        margin-right:20px;
        font-size: 16px;
        position: relative;
        cursor: pointer;
        font-weight: 500;
        >svg{
            position: absolute;
            color:#fff;
            top: 0px;
            left:-2px;
            font-size: 18px;
            opacity: 0;
            transform: scale(0);
            transition: .2s;
        }
        &::before{
            content:'';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            transition: .2s;
            margin-right: 2px;
            background-image: linear-gradient(to right, #bbb , #A3A3A3);
        }
        &.disabled{
            color:#ccc;
            cursor: default;
            &::before{
                content:"";
                background:#ccc;
                
            }
        }
    }
}
</style>
