<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

import ValidationErrors from '@components/ValidationErrors.vue';
import GuestLayout from '@layouts/Guest.vue';
import Button from '@components/Button.vue';
import Input from '@components/Input.vue';
import Label from '@components/Label.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="username" />
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
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
                </Link>

                <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </Button>
            </div>
        </form>
    </GuestLayout></template>
