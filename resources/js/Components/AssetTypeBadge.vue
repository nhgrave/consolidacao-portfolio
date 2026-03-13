<script setup>
import { computed } from 'vue';

const props = defineProps({
    assetType: {
        type: String,
        required: true,
        validate: (value) => {
            return ["fixed", "variable"].includes(value);
        },
    },
});

const text = computed(() => {
    return {
        fixed: 'Renda Fixa',
        variable: 'Renda Variável'
    }[props.assetType];
});
</script>

<template>
    <div :class="`badge-asset-type badge-asset-type-${assetType}`">
        <span>
            {{ text }}
        </span>
    </div>
</template>

<style scoped>
@reference "tailwindcss";

.badge-asset-type {
    @apply rounded-full px-2 py-1 text-xs font-semibold inline;
}

.badge-asset-type-fixed {
    @apply bg-blue-100 text-blue-800 ;
}

.badge-asset-type-variable {
    @apply bg-purple-100 text-purple-800;
}
</style>
