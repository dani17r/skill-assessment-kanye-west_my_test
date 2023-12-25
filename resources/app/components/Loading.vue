<script setup lang="ts">
interface PropsI {
    modelValue: boolean;
};
const props = defineProps<PropsI>()
</script>

<template>
    <div class="bg-white bg-opacity-70 w-full h-full absolute top-0 left-0 flex justify-center items-center"
        v-if="props.modelValue">
        <svg viewBox="0 0 200 200" class="h-20 w-20">
            <circle fill="none" stroke-opacity="1" stroke="#2563EB" stroke-width=".5" cx="100" cy="100" r="0">
                <animate attributeName="r" calcMode="spline" dur="2" values="1;80" keyTimes="0;1" keySplines="0 .2 .5 1"
                    repeatCount="indefinite"></animate>
                <animate attributeName="stroke-width" calcMode="spline" dur="2" values="0;25" keyTimes="0;1"
                    keySplines="0 .2 .5 1" repeatCount="indefinite"></animate>
                <animate attributeName="stroke-opacity" calcMode="spline" dur="2" values="1;0" keyTimes="0;1"
                    keySplines="0 .2 .5 1" repeatCount="indefinite"></animate>
            </circle>
        </svg>
    </div>
</template>
