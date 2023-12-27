<script setup lang="ts">
import type { PaginationI } from '@/types';

interface PropsI {
  data: PaginationI<any>;
}

const props = defineProps<PropsI>();
const emits = defineEmits(['change']);

const goPaginate = (url: string) => {
  if (url) {
    const go = Number(url.split('?page=')[1]);
    if (go != props.data.current_page) emits('change', go);
  }
}
</script>

<template>
  <div v-if="props.data.links.length > 3" class="flex items-center gap-3 xs:justify-between mt-5 flex-col xs:flex-row">
    <div>
      <span class="px-3 py-2 text-sm leading-4 text-zinc-700">Total {{ props.data.data.length }} of {{ props.data.total
      }}</span>
    </div>
    <div>
      <button v-for="(link, index) in props.data.links" :key="index"
        class="px-3 py-2 text-sm leading-4 text-zinc-700 rounded hover:text-indigo-500 focus:text-indigo-500"
        :class="{ 'rounded-full bg-indigo-400 !text-white hover:text-white  focus:text-white': link.active }"
        @click="goPaginate(link.url)" v-html="link.label"></button>
    </div>
  </div>
</template>