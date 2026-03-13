<script setup>
import AppHeader from '../Components/AppHeader.vue';

</script>

<template>
  <div>
    <AppHeader />

    <main class="px-4">
      <slot />
    </main>
  </div>
</template>
