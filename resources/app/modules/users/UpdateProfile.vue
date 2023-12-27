<script setup lang="ts">
import { useForm } from "@inertiajs/inertia-vue3";
import { useUserStore } from "@store/user";
import { storeToRefs } from "pinia";
import { pick } from "lodash";
import { ref } from "vue";

import InputImageProfile from "@components/InputImageProfile.vue";
import Loading from "@components/Loading.vue";

const userStore = useUserStore();
const { currentUser, loadings } = storeToRefs(userStore);

const form = useForm({
    name: currentUser.value.name,
    image: currentUser.value.image,
    email: currentUser.value.email,
});

const imgProfile = ref(null);

const updateProfile = () => {
    userStore.updateCurrentUser(form).then(({ user }) => {
        imgProfile.value?.updatePreviewImage()
        form.defaults(pick(user, ["email", "name", "image"]));
        form.reset();
    });
};

const cancelUpdateProfile = () => {
    imgProfile.value?.clearPreviewImage();
    form.reset();
}
</script>

<template>
    <form @submit.prevent="updateProfile" enctype="multipart/form-data" class="flex flex-col relative" v-if="currentUser">

        <InputImageProfile :image-url="currentUser.image" :fullname="currentUser.name" @clear="form.reset('image')"
            v-model="form.image" ref="imgProfile" />

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" type="text" v-model="form.name" />
            <div class="text-red-400 text-sm mt-1" v-if="form.errors.name">
                {{ form.errors.name }}
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="email">Email</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="email" v-model="form.email" />
            <div class="text-red-400 text-sm mt-1" v-if="form.errors.email">
                {{ form.errors.email }}
            </div>
        </div>
        <div class="flex flex-col h-full justify-end">
            <div class="flex gap-3">
                <button class="bg-blue-500 text-white px-4 py-2 rounded min-w-24" :type="form.isDirty ? 'submit' : 'button'"
                    :class="{ 'opacity-40': !form.isDirty }" :disabled="!form.isDirty">
                    Update
                </button>
                <button class="bg-gray-500 text-white px-4 py-2 rounded min-w-24"
                    @click="form.isDirty ? cancelUpdateProfile() : null" :class="{ 'opacity-40': !form.isDirty }"
                    :disabled="!form.isDirty" type="button">
                    Cancel
                </button>
            </div>
        </div>
        <Loading v-model="loadings.update" />
    </form>
</template>
