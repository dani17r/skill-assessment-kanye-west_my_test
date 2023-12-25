<script setup lang="ts">
interface PropsI {
    message: string;
};
const props = defineProps<PropsI>();
</script>

<template>
    <div v-show="props.message">
        <p class="text-sm text-red-600">
            {{ props.message }}
        </p>
    </div>
</template>
