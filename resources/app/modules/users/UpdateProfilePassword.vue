<script setup lang="ts">
import { useForm } from "@inertiajs/inertia-vue3";
import { useUserStore } from "@store/user";
import { storeToRefs } from "pinia";

import InputPassword from "@components/InputPassword.vue";
import Loading from "@components/Loading.vue";

const userStore = useUserStore();
const { loadings } = storeToRefs(userStore);

const form = useForm({
    check_new_password: "",
    current_password: "",
    new_password: "",
});

const updateProfilePassword = () => {
    userStore.updateUserPassword(form)
        .then(() => {
            form.reset();
        });
};
</script>

<template>
    <form @submit.prevent="updateProfilePassword()" class="flex flex-col relative">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="password">Current Password</label>
            <InputPassword
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="current_password" type="password" v-model="form.current_password" />
            <div class="text-red-400 text-sm mt-1" v-if="form.errors.current_password">{{ form.errors.current_password }}
            </div>
        </div>
        <div class="mb-4 relative">
            <label class="block text-gray-700 font-bold mb-2" for="password">New Password</label>
            <InputPassword
                class="shadow appearance-none border rounded w-full py-2 pl-3 pr-5 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="new_password" v-model="form.new_password" />
            <div class="text-red-400 text-sm mt-1" v-if="form.errors.new_password">{{ form.errors.new_password }}</div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="password">Check New Password</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="check_new_password" type="password" v-model="form.check_new_password" />
            <div class="text-red-400 text-sm mt-1" v-if="form.errors.check_new_password">{{ form.errors.check_new_password
            }}</div>
        </div>
        <div class="flex flex-col h-full justify-end">
            <div class="flex gap-3">
                <button class="bg-blue-500 text-white px-4 py-2 rounded min-w-24" :type="form.isDirty ? 'submit' : 'button'"
                    :class="{ 'opacity-40': !form.isDirty }" :disabled="!form.isDirty">
                    save
                </button>
                <button class="bg-gray-500 text-white px-4 py-2 rounded min-w-24"
                    @click="form.isDirty ? form.reset() : null" :class="{ 'opacity-40': !form.isDirty }"
                    :disabled="!form.isDirty" type="button">
                    Cancel
                </button>
            </div>
        </div>
        <Loading v-model="loadings.updatePassword" />
    </form>
</template>
