<script setup>
import { ref, onMounted, computed } from "vue";
import store from "../store";
import { ARTICLES_PER_PAGE } from "../constants";
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const perPage = ref(ARTICLES_PER_PAGE);
const search = ref("");
const sortField = ref("updated_at");
const sortDirection = ref("desc");

const letters = computed(() => store.state.letters);
const categories = ref({})
const checkedItems = ref([]);
const isSelectAllChecked = ref(false);
const checkItem = ref(null);
onMounted(() => {
  getLetters();
});
const getForPage = (ev, link) => {
  if (!link.url || link.active) return;

  getLetters(link.url);
};

const getLetters = (url = null) => {
  store.dispatch("getLetters", {
    url,
    sort_field: sortField.value,
    sort_direction: sortDirection.value,
    search: search.value,
    perPage: perPage.value,
  });
};
const sortLetters = (field) => {
  sortField.value = field;
  if (sortField.value === field) {
    if (sortDirection.value === "asc") {
      sortDirection.value = "desc";
    } else {
      sortDirection.value = "asc";
    }
  } else {
    sortField.value = field;
    sortDirection.value = "asc";
  }

  getLetters();
};
const deleteLetter = (letter) => {
  if (!confirm(`確定要刪除 ${letter.title} 嗎？`)) return;
  store.dispatch("deleteLetter", letter.id).then((res) => {
    alert("刪除成功！");
    getLetters();
  });
};
const selectedCheckItem = () => {
  if (checkedItems.value.length < letters.value.total) {
    isSelectAllChecked.value = false;
  }
};
const selectAllCheckItems = () => {
  if (isSelectAllChecked.value) {
    checkItem.value.forEach((item) => {
      checkedItems.value.push(item.value);
    });
  } else {
    checkItem.value.forEach((item) => {
      checkedItems.value = [];
    });
  }
};
const deleteCheckedItems = () => {
  if (confirm("確定刪除？")) {
    store.dispatch("deleteLetterItems", checkedItems.value).then((res) => {
      alert("刪除成功！");
      getLetters();
      checkedItems.value = [];
    });
  }
};
</script>

<template>
  <div class="letters">
    <pre></pre>
    <h1>Inbox</h1>
    <div class="card">
      <div class="card-header">
        <div class="left">
          <div class="form-group">
            <div class="icon">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                />
              </svg>
            </div>
            <input
              type="text"
              placeholder="搜尋..."
              v-model="search"
              @change="getLetters()"
            />
          </div>
          <div class="form-group">
            <select v-model="perPage" @change="getLetters()">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-auto w-full animate-fade-in-down">
          <tbody v-if="letters.loading" class="loadingTable">
            <tr>
              <td colspan="7" class="w-full" style="text-align: center">
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
              </td>
            </tr>
          </tbody>
          <tbody v-else class="mainbody">
            <tr
              v-for="(letter, idx) of letters.data"
              :key="letter.id"
              class="animate-fade-in-down mainTr"
            >
              <td class="w-[20px]">
                <input
                  type="checkbox"
                  v-model="checkedItems"
                  @change="selectedCheckItem()"
                  ref="checkItem"
                  :value="letter.id"
                />
              </td>
              <td class="text-sm text-gray-600" @click="router.push({name:'app.readmail', params: { id: letter.id }})">{{ letter.name }}</td>
              <td class="content text-gray-600" @click="router.push({name:'app.readmail', params: { id: letter.id }})"><small>{{ letter.content }}</small></td>
              <td class="w-[10%] text-xs text-gray-500" @click="router.push({name:'app.readmail', params: { id: letter.id }})">{{ letter.ago }}</td>
            </tr>
            <tr v-if="letters.data.length > 0">
              <td colspan="7">
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-4 h-4 text-gray-900"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"
                    />
                  </svg>
                  <button
                    :class="[
                      { 'bg-red-600': checkedItems.length > 0 },
                      'py-1',
                      'px-3',
                      'ml-4',
                      'text-white',
                      'rounded-sm',
                      { 'bg-gray-400': checkedItems.length <= 0 },
                    ]"
                    :disabled="checkedItems.length <= 0"
                    @click="deleteCheckedItems()"
                  >
                    一鍵刪除
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="paging" v-if="letters.total > letters.limit">
        <div class="pageInfo text-xs text-gray-500">第 {{ letters.from }} 筆 至 第 {{ letters.to }}筆</div>
        <div class="pageBtn">
          <nav>
            <a
              href="#"
              v-for="(link, i) of letters.links"
              :key="i"
              @click.prevent="getForPage($event, link)"
              :disabled="!link.url"
              :class="[{ active: link.active }, { disabled: !link.url }]"
              v-html="link.label"
            ></a>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.letters {
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
    padding: 1.5rem 2.5rem;
    margin-top: 25px;
    > .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 10px;
      .left,
      .right {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        .form-group {
          display: flex;
          align-items: center;
          .icon {
            background-color: #fff;
            width: 40px;
            height: 40px;
            border: 1px solid #aaa;
            border-right: none;
            padding: 11px 0px 12px 19px;
            border-radius: 30px 0 0 30px;
            margin-right: 0;
          }
          input[type="text"] {
            background-color: #fff;
            border: 1px solid #aaa;
            width: 190px;
            height: 40px;
            border-radius: 30px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 0;
            outline: none;
            padding: 15px 18px 15px 16px;
            font-size: 14px;
            color:#333;
          }
          .btn {
            color: #f6f6f6;
            cursor: pointer;
            background-color: #34c38f;
            border-radius: 35px;
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
          select {
            color: #333;
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 0.25rem;
            width: 100px;
            height: 40px;
            padding: 0 7px;
            outline: none;
            margin-left: 15px;
            font-size: 15px;
          }
        }
      }
    }
    > .table-responsive {
      margin-top: 20px;
      > table {
        margin: 0 auto;
        width: 100%;
        font-size: 14px;
        > tbody {
          background-color: transparent;
          &.loadingTable {
            td {
              text-align: center;
              padding: 30px 0;
              > svg {
                margin: 0 auto;
              }
            }
          }
          &.mainbody > tr.mainTr{
                cursor: pointer;
                transition: .3s;
                &:hover{
                    background-color: #f2f2f2;
                }
            } 
          > tr {
            > td {
              text-align: left;
              padding:  20px 15px;
              min-width: 100px;
              &.content{
                  small{
                    font-size: 13px;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 1;
                    overflow: hidden;
                    padding: 0 60px 0 30px;
                }
              }
              img {
                width: 65px;
                height: 40px;
                object-fit: cover;
              }
              button {
                &.edit {
                  color: #2ca67a;
                }
                &.delete {
                  color: rgb(200, 6, 6);
                }
              }
              span {
                padding: 3px 4px;
                border-radius: 3px;
                color: #ef6767;
                background-color: rgba(239, 103, 103, 0.18);
                &.active {
                  color: #34c38f;
                  background-color: rgba(52, 195, 143, 0.18);
                }
              }
            }
          }
        }
      }
    }
    > .paging {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      > .pageBtn {
        nav {
          display: flex;
          justify-content: center;
          align-items: center;
          a {
            color: #aaa;
            border-radius: 30px !important;
            margin: 0 3px !important;
            border: none;
            width: 32px;
            height: 32px;
            padding: 0;
            text-align: center;
            line-height: 32px;
            font-size: 12px;
            transition: 0.3s;
            &:hover {
              color: #fff;
              background-color: #282f36;
            }
            &.active {
              background-color: #1c84ee;
              border-color: #1c84ee;
              color:#fff;
              &:hover {
                color: #fff;
                background-color: #1c84ee;
              }
            }
            &.disabled {
              cursor: default;
              color: #777;
              &:hover {
                color: #777;
                background-color: #242a30;
              }
            }
          }
        }
      }
    }
  }
}
</style>
