<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';

import ValidationErrors from '@components/ValidationErrors.vue';
import Button from '@components/Button.vue';
import GuestLayout from '@layouts/Guest.vue';
import Input from '@components/Input.vue';
import Label from '@components/Label.vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
};
</script>

<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                    autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
