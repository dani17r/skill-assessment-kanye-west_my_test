<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';
import { useUserStore } from '@store/user';

import UpdateProfilePassword from '@modules/users/UpdateProfilePassword.vue';
import AuthenticatedLayout from '@layouts/Authenticated.vue';
import UpdateProfile from '@modules/users/UpdateProfile.vue';

const userStore = useUserStore();
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="py-12" v-if="userStore.currentUser">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h1 class="text-2xl font-bold mb-4">User Profile</h1>
                    <div class="flex flex-col gap-8 md:flex-row">
                        <UpdateProfile class="w-full" />
                        <UpdateProfilePassword class="w-full" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>