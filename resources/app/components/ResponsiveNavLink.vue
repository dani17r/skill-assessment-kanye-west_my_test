<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

interface PropsI {
    href: string;
    active?: boolean;
};
const props = defineProps<PropsI>();

const classes = computed(() => {
    const repit = `block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out`
    return props.active
        ? 'border-indigo-400  text-indigo-700 bg-indigo-50  focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700' + repit
        : ' border-transparent  text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300  focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300' + repit
});
</script>

<template>
    <Link :href="props.href" :class="classes">
    <slot />
    </Link>
</template>
