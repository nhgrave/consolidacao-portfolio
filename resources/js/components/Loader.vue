<script setup>
</script>

<template>
    <div class="flex items-center justify-center h-full">
        <div class="loader"></div>
    </div>
</template>

<style scoped>
.loader {
    width: 20px;
    height: 20px;
    border: 3px solid currentColor;
    border-left-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
