<script setup>
defineProps({
    show: Boolean
})
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center"
        >

            <!-- overlay -->
            <div
                class="absolute inset-0 bg-black/40"
                @click="$emit('close')"
            ></div>

            <!-- modal -->
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">
                        <slot name="title" />
                    </h2>

                    <button
                        @click="$emit('close')"
                        class="text-gray-400 hover:text-gray-600 cursor-pointer"
                    >
                        ✕
                    </button>
                </div>

                <div>
                    <slot />
                </div>
            </div>
        </div>
    </Teleport>
</template>
