<template>
    <div class="space-y-4">
        <div
            v-for="i in 3"
            :key="i"
            class="animate-pulse bg-white p-4 rounded-lg shadow"
        >
            <div class="flex justify-between items-center">
                <div class="h-4 w-32 bg-gray-200 rounded"></div>
                <div class="h-4 w-20 bg-gray-200 rounded"></div>
            </div>

            <div class="mt-3 h-3 w-40 bg-gray-200 rounded"></div>
        </div>
    </div>
</template>
