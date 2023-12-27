<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';

import ValidationErrors from '@components/ValidationErrors.vue';
import GuestLayout from '@layouts/Guest.vue';
import Button from '@components/Button.vue';
import Input from '@components/Input.vue';
import Label from '@components/Label.vue';

interface PropsI {
    email: string,
    token: string,
}

const props = defineProps<PropsI>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label for="password_confirmation" value="Confirm Password" />
                <Input id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </Button>
            </div>
        </form>
</GuestLayout></template>
