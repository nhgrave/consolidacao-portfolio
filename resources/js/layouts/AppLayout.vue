<script setup>
import AppHeader from '../components/AppHeader.vue';

</script>

<template>
  <div>
    <AppHeader />

    <main class="px-4 max-w-300 mx-auto py-6">
      <slot />
    </main>
  </div>
</template>
