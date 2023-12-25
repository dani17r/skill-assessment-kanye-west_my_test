<script setup lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
import { useUserStore } from "@store/user";
import { ref } from "vue";

import ResponsiveNavLink from "@components/ResponsiveNavLink.vue";
import ApplicationLogo from "@components/ApplicationLogo.vue";
import ImageProfile from "@components/imageProfile.vue";
import Dropdown from "@components/Dropdown.vue";
import NavLink from "@components/NavLink.vue";

const showingNavigationDropdown = ref(false);
const userStore = useUserStore();

userStore.getCurrentUser();
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100 fixed left-0 top-0 w-full z-10">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                <ApplicationLogo class="block h-9 w-auto" />
                </Link>
              </div>
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')"> Dashboard </NavLink>
                <NavLink :href="route('favorite')" :active="route().current('favorite')"> Favorite </NavLink>
              </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative" v-if="userStore.currentUser">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ userStore.currentUser.name }} </button>
                      <ImageProfile :fullname="userStore.currentUser.name" :image-url="userStore.currentUser.image"
                        class="cursor-pointer" />
                    </span>
                  </template>
                  <template #content>
                    <Link class="dropdown-link" :class="route().current('profile') ? '!text-indigo-700' : ''" :href="route('profile')" as="button" > Profile </Link>

                    <Link class="dropdown-link" :href="route('logout')" method="post" as="button"
                      @click="userStore.emptyCurrentUser()"> Logout </Link>
                  </template>
                </Dropdown>
              </div>
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button @click=" showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown, }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown, }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')"> Dashboard
            </ResponsiveNavLink>
          </div>
          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4" v-if="userStore.currentUser">
              <div class="font-medium text-base text-gray-800"> {{ userStore.currentUser.name }} </div>
              <div class="font-medium text-sm text-gray-500"> {{ userStore.currentUser.email }} </div>
            </div>
            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('logout')" method="post" as="button"> Log Out </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>
      <main class="mt-16">
        <slot />
      </main>
  </div>
</div>
</template>