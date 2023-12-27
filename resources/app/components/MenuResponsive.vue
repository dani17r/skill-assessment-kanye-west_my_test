<script setup lang="ts">
import { useUserStore } from "@store/user";

import ResponsiveNavLink from "@components/ResponsiveNavLink.vue";

interface PropsI {
  status: boolean,
}
const props = defineProps<PropsI>();

const userStore = useUserStore();
</script>

<template>
  <div :class="{ 'block': props.status, 'hidden': !props.status, }" class="sm:hidden z-50">
    <div class="pt-2 pb-3 space-y-1 w-full">
      <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" as="button"
        class="flex w-full"> Dashboard
      </ResponsiveNavLink>
      <ResponsiveNavLink v-if="userStore.isBanning" :href="route('favorite')" :active="route().current('favorite')"
        as="button" class="flex w-full"> Favorites
      </ResponsiveNavLink>
      <ResponsiveNavLink :href="route('profile')" :active="route().current('profile')" as="button" class="flex w-full">
        Profile
      </ResponsiveNavLink>
      <ResponsiveNavLink v-if="userStore.isAdmin" :href="route('users')" :active="route().current('users')" as="button"
        class="flex w-full"> Users </ResponsiveNavLink>
    </div>

    <div class="pt-4 pb-1 border-t border-gray-200">
      <div class="px-4" v-if="userStore.currentUser">
        <div class="font-medium text-base text-gray-800"> {{ userStore.currentUser.name }} </div>
        <div class="font-medium text-sm text-gray-500"> {{ userStore.currentUser.email }} </div>
      </div>
      <div class="mt-3 space-y-1">
        <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="flex w-full"> Log Out
        </ResponsiveNavLink>
      </div>
    </div>
  </div>
</template>