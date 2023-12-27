<script setup lang="ts">
import composableFavorites from '@composables/favorites';
import { useInfiniteScroll } from '@vueuse/core';
import { useQuoteStore } from '@store/quote';
import { useUserStore } from '@store/user';
import type { FavoriteI } from '@/types';
import { onMounted, ref } from 'vue';

import Loading from '@components/Loading.vue';
import Icons from '@components/icons';

const userStore = useUserStore();

const { favoriteStore, changeInFavorite, favorites, loadings, lifecycles } = composableFavorites();
const quoteStore = useQuoteStore();
const elScroll = ref<HTMLElement | null>(null);

const updateOrDeleteFavorite = (status: 'like' | 'dislike', item: FavoriteI) => {
  changeInFavorite(status, item);
  quoteStore.updateQuotesByFavorites(item);
}

const initScrolling = () => useInfiniteScroll(
  elScroll,
  () => favoriteStore.getFavorites(true),
  {
    interval: 1000,
    canLoadMore: () => lifecycles.value.scrolling,
  },
);

onMounted(() => {
  initScrolling();
  favoriteStore.getFavorites()
});
</script>

<template>
  <div class="flex justify-between justify-items-center mb-4">
    <h1 class="text-2xl text-zinc-700 p-1">Favorites</h1>

    <div>
      <span class="p-2 text-zinc-500"> Total {{ favorites.length }} </span>
      <span class="p-2 text-zinc-500"> Limit {{ userStore.currentUser?.moderating }} </span>
    </div>
  </div>
  <div class="relative min-h-26" v-if="favorites.length">
    <ul class="divide-y divide-zinc-200 max-h-[420px] scrollable overflow-x-hidden pr-2" ref="elScroll">
      <li class="p-6 sm:pb-4" v-for="(item, index) in favorites" :key="index">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
          <div class="text-sm text-zinc-500">{{ index + 1 }}</div>
          <div class="group relative cursor-pointer">
            <div
              class="block md:hidden absolute invisible bottom-7 group-hover:visible w-60 bg-indigo-400 text-white px-4 mb-3 py-2 text-sm rounded-md">
              <p class=" leading-2 pt-1 pb-1">{{ item.quote }}</p>
            </div>
            <Icons.Docs class="w-8 h-8 stroke-zinc-400 hover:cursor-pointer" />
          </div>

          <div class="flex-1 min-w-0">
            <p class="text-sm text-zinc-700 truncate">
              {{ item.quote }}
            </p>
          </div>
          <div class="inline-flex items-center gap-3">
            <button class="text-green-500" @click="[updateOrDeleteFavorite('like', item)]">
              <Icons.Like :class="['hover:fill-green-500', { 'fill-green-400': item.like }]" />
            </button>
            <button class="text-red-400" @click="updateOrDeleteFavorite('dislike', item)">
              <Icons.Dislike :class="['hover:fill-red-400', { 'fill-red-400': item.dislike }]" />
            </button>
          </div>
        </div>
      </li>
    </ul>

    <Loading v-model="loadings.init" />
  </div>
  <div v-else class="relative flex justify-center items-center w-full min-h-26">
    <h1 class="text-xl text-indigo-800">There are no favorites yet.</h1>
  </div>
</template>