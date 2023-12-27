<script setup lang="ts">
import composableFavorites from '@composables/favorites';
import { onMounted, computed, ref } from 'vue';
import { useQuoteStore } from '@store/quote';
import { useUserStore } from '@store/user';
import type { QuoteI } from '@/types';
import { storeToRefs } from 'pinia';

import Loading from '@components/Loading.vue';
import ModalMessage from '@components/ModalMessage.vue';
import Icons from '@components/icons';

const quoteStore = useQuoteStore();
const userStore = useUserStore();
const modal = ref(false);
const { currentUser } = storeToRefs(userStore);
const { quotes, loadings, totalFavorites, limit, limitSelect } = storeToRefs(quoteStore);

const { changeInFavorite } = composableFavorites();

const isModerating = computed(() => totalFavorites.value < currentUser.value?.moderating || 0);

const updateOrCreateFavorite = (status: 'like' | 'dislike', item: QuoteI) => {
  if (isModerating.value) changeInFavorite(status, item);
  else {
    if (item.dislike == true || item.like == true) changeInFavorite(status, item);
    else modal.value = true;
  }
}

onMounted(() => quoteStore.getQuotes())
</script>

<template>
  <div class="flex justify-between justify-items-center mb-4">
    <h1 class="text-2xl text-zinc-700 p-1">Randon Quotes</h1>

    <div class="flex gap-3">
      <div class="w-[70px]">
        <select id="randon" v-model="limit"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
          <option v-for="(item, index) in limitSelect" :key="index" :value="item">{{ item }}</option>
        </select>
      </div>

      <button class="rounded-full hover:bg-zinc-100 p-2 text-zinc-600" @click="quoteStore.getQuotes(true)">
        <Icons.Refresh />
      </button>
    </div>

  </div>
  <div class="relative min-h-56">
    <ul class="divide-y divide-zinc-200 max-h-[420px] scrollable overflow-x-hidden pr-2">
      <li class="p-3 sm:pb-4" v-for="(item, index) in quotes" :key="index">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
          <div class="flex-shrink-0">
            <div class="group relative cursor-pointer">
              <div
                class="block md:hidden absolute invisible bottom-7 group-hover:visible w-60 bg-indigo-400 text-white px-4 mb-3 py-2 text-sm rounded-md">
                <p class=" leading-2 pt-1 pb-1">{{ item.quote }}</p>
              </div>
              <Icons.Docs class="w-8 h-8 stroke-zinc-400 hover:cursor-pointer" />
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm text-zinc-700 truncate">
              {{ item.quote }}
            </p>
          </div>
          <div class="inline-flex items-center gap-3" v-if="userStore.isBanning">
            <button class="text-green-500" @click="updateOrCreateFavorite('like', item)">
              <Icons.Like :class="['hover:fill-green-500', { 'fill-green-400': item.like }]" />
            </button>
            <button class="text-red-400" @click="updateOrCreateFavorite('dislike', item)">
              <Icons.Dislike :class="['hover:fill-red-400', { 'fill-red-400': item.dislike }]" />
            </button>
          </div>
        </div>
      </li>
    </ul>

    <Loading v-model="loadings.init" />
    <ModalMessage :status="modal" @change="modal = !modal" title="You have a maximum favorites limit" />
  </div>
</template>