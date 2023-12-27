<script setup lang="ts">
import { debounceIndex, formatDate } from "@utils/index";
import { useUserStore } from "@store/user";
import { storeToRefs } from "pinia";
import { onMounted } from "vue";
import { isNull } from "lodash";

import ImageProfile from "@components/imageProfile.vue";
import Pagination from "@components/Pagination.vue";
import Loading from '@components/Loading.vue';
import Icons from "@components/icons";
import type { UserI } from "@/types";

const userStore = useUserStore();
const { users, loadings } = storeToRefs(userStore);

const moderatingFavorite = (status: string, item: UserI) => {
  if (status == 'max') item.moderating += 1;
  if (status == 'min') {
    if (item.moderating > 0) item.moderating -= 1;
  }
}

const saveUserModerating = debounceIndex((item: UserI) => {
  userStore.updateUserByAdmin(item);
}, 900);

const saveUserBanning = (item: UserI) => {
  setTimeout(() => userStore.updateUserByAdmin(item), 300);
};

onMounted(() => userStore.getUsers());
</script>

<template>
  <div class="relative min-h-[120px]">
    <div class="max-h-[450px] scrollable overflow-x-scroll">
      <table class="w-full text-sm text-left text-gray-500" v-if="users.data.length">
        <thead class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th class="px-3 py-3 text-left">#</th>
            <th class="px-3 py-3 text-left">Image</th>
            <th class="px-3 py-3 text-left">Name</th>
            <th class="px-3 py-3 text-left">Email</th>
            <th class="px-3 py-3 text-left">Verified</th>
            <th class="px-3 py-3 text-left">Created At</th>
            <th class="px-3 py-3 text-left">Banning</th>
            <th class="px-3 py-3 text-left">Moderating</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in users.data" :key="index" class="border-b">
            <th class="px-3 py-3 font-medium whitespace-nowrap"> {{ index + 1 }} </th>
            <th class="px-3 py-3 text-center font-medium whitespace-nowrap">
              <ImageProfile :image-url="item.image" :fullname="item.name" class="w-8 h-8 md:h-10 md:w-10" />
            </th>
            <th class="px-3 py-3 text-left font-medium whitespace-nowrap text-indigo-500"> {{ item.name }} </th>
            <th class="px-3 py-3 text-left font-medium whitespace-nowrap"> {{ item.email }} </th>
            <td class="px-3 py-3 text-center">
              <div class="flex justify-center items-center">
                <Icons.Check class="text-indigo-600" v-if="!isNull(item.email_verified_at)" />
                <Icons.Exclamation class="text-red-400" v-else />
              </div>
            </td>
            <td class="px-3 py-3 text-left"> {{ formatDate(item.created_at) }} </td>
            <td class="px-3 py-3 text-left">
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="item.banning" class="sr-only peer" @input="() => saveUserBanning(item)">
                <div class="peer content-checkbox"></div>
              </label>
            </td>
            <td class="px-3 py-3 text-left min-w-[160px] w-[160px]">
              <div class="relative flex items-center mb-2">
                <button
                  class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:outline-none"
                  @click="[moderatingFavorite('min', item), saveUserModerating(index, item)]">
                  <Icons.Min />
                </button>
                <input type="text"
                  class="bg-gray-50 border-x-0 border-gray-300 h-11 font-medium text-center text-gray-900 blo2ck w-full outline-none focus:ring-0"
                  v-model="item.moderating" @input="saveUserModerating(index, item)">
                <button
                  class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:outline-none"
                  @click="[moderatingFavorite('max', item), saveUserModerating(index, item)]">
                  <Icons.Max />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :data="users" @change="(page: number) => userStore.getUsers(true, page)" />

    <Loading v-model="loadings.updateUsers" />
  </div>
</template>