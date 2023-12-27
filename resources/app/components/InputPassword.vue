<script setup lang="ts">
import { ref } from "vue";

import Icons from "@components/icons";

interface PropsI {
  modelValue: string;
};
defineOptions({ inheritAttrs: false });
const props = defineProps<PropsI>()

const viewPass = ref(false);
</script>

<template>
  <div class="relative">
    <input v-bind="$attrs" :value="props.modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      :type="viewPass ? 'text' : 'password'" />
    <div class="absolute bottom-2 right-2">
      <Icons.EyeHide @click="viewPass = !viewPass" v-if="viewPass" />
      <Icons.Eye @click="viewPass = !viewPass" v-else />
    </div>
  </div>
</template>