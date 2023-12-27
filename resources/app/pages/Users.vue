<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';

import AuthenticatedLayout from '@layouts/Authenticated.vue';
import ListUsers from '@modules/users/List.vue';
</script>

<template>
  <Head title="Users Panel" />

  <AuthenticatedLayout>
    <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-1 py-2 md:p-5 bg-white border-b border-gray-200">
            <ListUsers />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
