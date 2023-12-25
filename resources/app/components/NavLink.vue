<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

interface PropsI {
    href: string;
    active?: boolean;
};
const props = defineProps<PropsI>();

const classes = computed(() => {
    const general = 'd-flex flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out';
    
    return props.active
    ? 'border-indigo-400 text-gray-900 focus:border-indigo-700'+ general
    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300'+ general
});
</script>

<template>
    <Link :href="props.href" :class="classes">
        <slot />
    </Link>
</template>
