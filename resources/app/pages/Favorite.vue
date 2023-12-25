<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';

import AuthenticatedLayout from '@layouts/Authenticated.vue';
import ListFavoriteQuote from '@modules/Favorites/List.vue';
</script>

<template>
  <Head title="Favorite" />

  <AuthenticatedLayout>
    <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <ListFavoriteQuote />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
