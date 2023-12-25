<script setup lang="ts">
interface PropsI {
    value: string;
};
const props = defineProps<PropsI>();
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="props.value">{{ props.value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
