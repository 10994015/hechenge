<script setup>
import { ref, onMounted, computed } from "vue";
import store from "../store";
import { FAQ_PER_PAGE } from "../constants";
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const perPage = ref(FAQ_PER_PAGE);
const search = ref("");
const sortField = ref("updated_at");
const sortDirection = ref("desc");

const faqs = computed(() => store.state.faqs);
const categories = ref({})
const checkedItems = ref([]);
const isSelectAllChecked = ref(false);
const checkItem = ref(null);
onMounted(() => {
  getFaqs();
});
const getForPage = (ev, link) => {
  if (!link.url || link.active) return;

  getFaqs(link.url);
};

const getFaqs = (url = null) => {
  store.dispatch("getFaqs", {
    url,
    sort_field: sortField.value,
    sort_direction: sortDirection.value,
    search: search.value,
    perPage: perPage.value,
  });
};
const sortFaqs = (field) => {
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

  getFaqs();
};
const deleteFaq = (faq) => {
  if (!confirm(`確定要刪除 ${faq.question} 嗎？`)) return;
  store.dispatch("deleteFaq", faq.id).then((res) => {
    alert("刪除成功！");
    getFaqs();
  });
};
const selectedCheckItem = () => {
  if (checkedItems.value.length < faqs.value.total) {
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
    store.dispatch("deleteFaqItems", checkedItems.value).then((res) => {
      alert("刪除成功！");
      getFaqs();
      checkedItems.value = [];
    });
  }
};
</script>

<template>
  <div class="faqs">
    <pre></pre>
    <h1>學生回饋列表</h1>
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
              @change="getFaqs()"
            />
          </div>
          <div class="form-group">
            <select v-model="perPage" @change="getFaqs()">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>
        <div class="right">
          <div class="form-group">
            <router-link
              class="btn"
              :to="{ name: 'app.add-faq', params: { id: 'create' } }"
              >+ 新增問答</router-link
            >
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-auto w-full animate-fade-in-down">
          <thead>
            <tr>
              <th class="w-[20px]">
                <input
                  type="checkbox"
                  v-model="isSelectAllChecked"
                  @change="selectAllCheckItems()"
                />
              </th>
              <th
                @click="sortFaqs('id')"
                :class="['w-[40px]', 'cursor-pointer', { active: sortField === 'id' }]"
              >
                <div class="flex items-center">
                  <div>ID</div>
                  <div class="ml-2" v-if="sortField === 'id'">
                    <svg
                      v-if="sortDirection === 'desc'"
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
                        d="M4.5 15.75l7.5-7.5 7.5 7.5"
                      />
                    </svg>
                    <svg
                      v-if="sortDirection === 'asc'"
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
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                      />
                    </svg>
                  </div>
                </div>
              </th>
              <th
                @click="sortFaqs('question')"
                :class="['cursor-pointer', { active: sortField === 'question' }]"
              >
                <div class="flex items-center">
                  <div>問題</div>
                  <div class="ml-2" v-if="sortField === 'question'">
                    <svg
                      v-if="sortDirection === 'desc'"
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
                        d="M4.5 15.75l7.5-7.5 7.5 7.5"
                      />
                    </svg>
                    <svg
                      v-if="sortDirection === 'asc'"
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
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                      />
                    </svg>
                  </div>
                </div>
              </th>
              <th
                @click="sortFaqs('updated_at')"
                :class="['cursor-pointer', { active: sortField === 'updated_at' }]"
              >
                <div class="flex items-center">
                  <div>最後更新時間</div>
                  <div class="ml-2" v-if="sortField === 'updated_at'">
                    <svg
                      v-if="sortDirection === 'desc'"
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
                        d="M4.5 15.75l7.5-7.5 7.5 7.5"
                      />
                    </svg>
                    <svg
                      v-if="sortDirection === 'asc'"
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
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                      />
                    </svg>
                  </div>
                </div>
              </th>
              <th>是否顯示</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody v-if="faqs.loading" class="loadingTable">
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
          <tbody v-else>
            <tr
              v-for="(faq, idx) of faqs.data"
              :key="faq.id"
              class="animate-fade-in-down"
            >
              <td class="w-[20px]">
                <input
                  type="checkbox"
                  v-model="checkedItems"
                  @change="selectedCheckItem()"
                  ref="checkItem"
                  :value="faq.id"
                />
              </td>
              <td class="w-[40px]">{{ faq.id }}</td>
              <td>{{ faq.question }}</td>
              <td>{{ faq.updated_at }}</td>
              <td>
                <span v-if="faq.hidden">隱藏</span
                ><span v-else class="active">顯示</span>
              </td>
              <td>
                <button
                  class="edit ml-1"
                  @click="
                    router.push({ name: 'app.add-faq', params: { id: faq.id } })
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                    />
                  </svg>
                </button>
                <button class="delete ml-5" @click="deleteFaq(faq)">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                    />
                  </svg>
                </button>
              </td>
            </tr>

            <tr v-if="faqs.data.length > 0">
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
      <div class="paging" v-if="faqs.total > faqs.limit">
        <div class="pageInfo">Showing from {{ faqs.from }} to {{ faqs.to }}</div>
        <div class="pageBtn">
          <nav>
            <a
              href="#"
              v-for="(link, i) of faqs.links"
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
.faqs {
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
        > thead {
          background-color: #f1f1f1;
          > tr {
            > th {
              text-align: left;
              padding: 15px;
              color:#333;
              &.active {
                background-color: #e1e1e1;
              }
              >div{
                color: #333;
              }
            }
          }
        }
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
          > tr {
            border-bottom: 1px #2f373f solid;
            > td {
              text-align: left;
              padding: 15px;
              min-width: 100px;
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
            color: #fff;
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
              color: #1c84ee;
              background-color: #282f36;
            }
            &.active {
              background-color: #1c84ee;
              border-color: #1c84ee;
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
