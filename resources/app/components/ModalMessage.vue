<script setup lang="ts">
import Icons from '@components/icons';

interface PropsI {
  status: boolean;
  title: string;
  description?: string;
}

const emit = defineEmits(['change']);
const props = defineProps<PropsI>();
</script>

<template>
  <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true"
    :class="props.status ? 'show' : 'hide'" @click="$emit('change')">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" :class="props.status ? 'show' : 'hide'"
      @click="$emit('change')"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start" :class="{ '!items-center !sm:items-center': !props.description }">
              <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <Icons.Danger class="text-red-600" />
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900">{{ props.title }}</h3>
                <div class="mt-2" v-if="props.description">
                  <p class="text-sm text-gray-500">{{ props.description }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>