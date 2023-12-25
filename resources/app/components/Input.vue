<script setup lang="ts">
import { onMounted, ref } from 'vue';

interface PropsI {
    modelValue: string;
};

const emit = defineEmits(['update:modelValue']);
const props = defineProps<PropsI>();

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="props.modelValue" @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)" ref="input">
</template>
