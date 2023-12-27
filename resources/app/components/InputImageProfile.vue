<script setup lang="ts">
import { getFirstTwoInitialLetter } from "@/utils";
import { computed, ref } from "vue";

import Icons from "@components/icons";

interface PropsI {
  fullname: string,
  imageUrl: string,
  modelValue: string | Blob
}
const emit = defineEmits(['update:modelValue', 'clear']);
const props = defineProps<PropsI>();

const shortenedName = getFirstTwoInitialLetter(props.fullname);
const urlDefault = `https://placehold.co/400x400?text=${shortenedName}`;

const reactiveImgUrl = computed(() => {
  const urlProfile = `${location.origin}/${props.imageUrl}`;
  return props.imageUrl ? urlProfile : urlDefault;
});

const imagePreview = ref<string>(reactiveImgUrl.value);
const inputUpload = ref();

const setPreviewImage = (event: Event) => {
  const file = (event.target as HTMLInputElement).files[0];
  const reader = new FileReader();
  reader.onload = () => {
    imagePreview.value = reader.result.toString()
    imagePreview.value.toString();
    emit('update:modelValue', file);
  };
  reader.readAsDataURL(file);
};

const clearPreviewImage = () => {
  imagePreview.value = reactiveImgUrl.value;
  imagePreview.value.toString();

  emit('update:modelValue', '');
  inputUpload.value.value = ''
  emit('clear');
}

const updatePreviewImage = () => {
  setTimeout(() => {
    imagePreview.value = reactiveImgUrl.value
    imagePreview.value.toString();
  }, 200)
};

defineExpose({ clearPreviewImage, updatePreviewImage });
</script>

<template>
  <div class="flex items-center justify-center">
    <label for="image" class="cursor-pointer relative">
      <img class="h-32 w-32 rounded-full" :src="imagePreview" alt="Avatar" />
      <input @change="setPreviewImage($event)" accept=".jpg, .jpeg, .png, .webp" ref="inputUpload" class="hidden"
        type="file" id="image" capture />
    </label>
    <button type="button" class="bg-red-300 absolute top-0 right-0 cursor-pointer rounded-full p-1"
      v-if="!imagePreview.includes('images/profile/') && !imagePreview.includes('placehold.co/')"
      @click="clearPreviewImage()">
      <Icons.Close />
    </button>
  </div>
</template>
