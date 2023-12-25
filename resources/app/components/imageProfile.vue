<script setup lang="ts">
import { computed } from "vue";
import { getFirstTwoInitialLetter } from "@utils/index";

interface PropsI {
  fullname: string,
  imageUrl: string,
}

const emit = defineEmits(['update:modelValue']);
const props = defineProps<PropsI>();

const shortenedName = getFirstTwoInitialLetter(props.fullname);
const urlDefault = `https://placehold.co/400x400?text=${shortenedName}`;

const imagePreview = computed(() => {
  const urlProfile = `${location.origin}/${props.imageUrl}`;
  return props.imageUrl ?  urlProfile : urlDefault;
});
</script>

<template>
    <img
        class="h-12 w-12 rounded-full"
        :src="imagePreview"
        alt="Avatar"
    />
</template>
