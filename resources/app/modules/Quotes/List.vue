<script setup lang="ts">
import { useQuoteStore } from '@store/quote';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

import Loading from '@components/Loading.vue';

const quoteStore = useQuoteStore();
const { quotes, loadings } = storeToRefs(quoteStore);

const dislike = (item:{ dislike:boolean, quote:string}) => {
  quoteStore.updateOrCreateaFavoriteQuote({ 
    dislike: !item.dislike, 
    quote: item.quote,
    like: false, 
  });
}

const like = (item:{ like:boolean, quote:string}) => {
  quoteStore.updateOrCreateaFavoriteQuote({ 
    quote: item.quote,
    like: !item.like, 
    dislike: false, 
  });
}

onMounted(() => quoteStore.getQuotes())
</script>

<template>
  <div class="flex justify-between justify-items-center mb-4">
    <h1 class="text-2xl text-zinc-700 p-1">Quotes</h1>

    <button class="rounded-full hover:bg-zinc-100 p-2 text-zinc-600" @click="quoteStore.getQuotes(true)">
      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
      </svg>
    </button>

  </div>
  <div class="relative min-h-56">
    <ul class="divide-y divide-zinc-200">
      <li class="p-3 sm:pb-4" v-for="(item, index) in quotes" :key="index">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
          <div class="flex-shrink-0">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-zinc-400">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm text-zinc-700 truncate">
              {{ item.quote }}
            </p>
          </div>
          <div class="inline-flex items-center gap-3">
            <button class="text-green-500" @click="like(item)">
              <svg :class="['w-6 h-6 hover:fill-green-500', {'fill-green-400':item.like}]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z" />
              </svg>
            </button>
            <button class="text-red-400" @click="dislike(item)">
              <svg :class="['w-6 h-6 hover:fill-red-400', {'fill-red-400':item.dislike}]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                transform="rotate(180)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z">
                  </path>
                </g>
              </svg>
            </button>
          </div>
        </div>
      </li>
    </ul>

    <Loading v-model="loadings.init" />
  </div>
</template>