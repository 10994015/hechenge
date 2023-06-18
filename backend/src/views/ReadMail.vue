<script setup>
import { ref, onMounted, } from "vue";
import store from "../store";
import { useRouter, useRoute } from "vue-router";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
const route = useRoute();
const router = useRouter();
const DEFAULT_LETTER = {
  id: "",
  name: "",
  phone: "",
  grade: "",
  school: "",
  content: "",
};
const image_url = ref("");
const randerLoading = ref(false);

const loading = ref(false);
const previewImg = ref(null);
const errorMsg = ref(null);
const successMsg = ref(null);
const letter = ref({ ...DEFAULT_LETTER });
const isCreate = ref(false);
const successMsgSetNull = ()=>{
  successMsg.value = null;
}
onMounted(() => {
  
  const letterId = route.params.id;

  if (letterId === "create") {
    randerLoading.value = true;
    letter.value.id = letterId;
    isCreate.value = true;
    
    return;
  }
  store
    .dispatch("isExistLetter", letterId)
    .then((res) => {
      if (res.data) {
        store
          .dispatch("getLetter", letterId)
          .then((res) => {
            letter.value = res.data;
            randerLoading.value = true;
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

const editor = ref(ClassicEditor);

</script>

<template>
  <div class="addLetter">
    <h1>查看信件</h1>
    <div class="card">
      <div v-if="randerLoading" class="letter-content">
        <h2>{{ letter.name }} ({{letter.school}})</h2>
        <small>{{ letter.created_at }}</small>
        <span>聯絡電話:{{ letter.phone }}</span>
        <span>就讀學校: {{ letter.school }}</span>
        <span>就讀年級: {{ letter.grade }}</span>
        <h5>詢問內容:</h5>
        <article v-html="letter.content"></article>
        <button
            class="pre"
            type="button"
            @click="router.push({ name: 'app.inbox' })"
          >
            回列表
        </button>
      </div>
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
.addLetter {
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
    >.letter-content{
        h2{
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 5px;
        }
        >small{
            float: right;
            color:#777;
            font-size: 12px;
        }
        >span{
            display: block;
            margin-bottom: 4px;
            color:#555;
            font-size: 13px;
        }
        h5{
            margin-top: 15px;
            font-weight: 600;
        }
        >article{
            text-indent: 2em;
            font-size: 14px;
            letter-spacing: 1.2px;
            line-height: 1.5;
            margin-top: 8px;
            color:#666;
            padding: 10px 0 30px;
            border-bottom: 1px #ddd solid;
        }
        .pre {
          color: #f6f6f6;
          background-color: #74788D;
          border-color: #74788D;
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
          margin-top: 25px;
          &:hover {
            background-color: #5d6070;
            border-color: #5d6070;
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
</style>
