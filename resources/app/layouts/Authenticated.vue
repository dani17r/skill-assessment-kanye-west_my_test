<script setup lang="ts">
import { useUserStore } from "@store/user";
import { ref, onMounted } from "vue";

import HeaderResponsive from "@components/HeaderResponsive.vue";
import MenuResponsive from "@components/MenuResponsive.vue";
import Icons from "@components/icons";

const showingNavigationDropdown = ref(false);
const userStore = useUserStore();
const showMessage = ref(false);

onMounted(() => {
  userStore.getCurrentUser().then((val) => {
    if (val != false) showMessage.value = true
  })
});
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white border-b border-gray-100 fixed left-0 top-0 w-full z-50">

      <HeaderResponsive :status="showingNavigationDropdown" @menu="showingNavigationDropdown = !showingNavigationDropdown"/>

      <MenuResponsive :status="showingNavigationDropdown"/>
    </nav>
    <div class="bg-black w-full h-[100vh] bg-opacity-30 z-20 fixed top-0 left-0"
      :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown, }"
      @click=" showingNavigationDropdown = !showingNavigationDropdown"> </div>
    <main class="relative top-[70px]">
      <slot></slot>
    </main>

    <div class="fixed bottom-0 left-0 w-full py-1 px-5 bg-red-600 text-white" v-if="!userStore.isBanning && showMessage">
      <div class="flex justify-between">
        <p>Your account is temp banning</p>
        <Icons.Close class="cursor-pointer" @click="showMessage = false" />
      </div>
    </div>
    <div
      class="fixed bottom-3 right-3 py-1 px-2 flex gap-2 justify-around items-center bg-indigo-500 text-white rounded-md"
      v-if="userStore.isAdmin && showMessage">
      <p>Mode Admin</p>
      <Icons.Close class="cursor-pointer" @click="showMessage = false" />
    </div>
  </div>
</template>