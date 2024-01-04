<script setup lang="ts">
import ApplicationLogo from '@components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useUserStore } from "@store/user";
import { onMounted } from 'vue';

const userStore = useUserStore();

onMounted(() => userStore.getCurrentUser())
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 items-center pt-0">
        <div class="fixed top-0 right-0 px-6 py-4">
            <Link v-if="userStore.currentUser" :href="route('dashboard')" class="text-sm text-gray-700 underline">
            Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                Log in
                </Link>

                <Link :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col xs:flex-row justify-center pt-8 sm:justify-start sm:pt-0 items-center">
                <ApplicationLogo class="w-24 xs:w-28" />
                <h1 class="text-xl xs:text-3xl text-indigo-500 max-w-96 text-center">
                    Welcome to the website made by Daniel Rangel
                </h1>
            </div>
        </div>
    </div>
</template>
