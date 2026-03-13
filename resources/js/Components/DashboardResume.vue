<script setup>
import { computed } from 'vue';

const props = defineProps({
    resume: {
        type: Object,
        required: true,
    },
})

const netValue = computed(() => {
    return props.resume.total - props.resume.tax - props.resume.fee;
});
</script>

<template>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="border-b border-gray-100 p-4">
            <p class="font-bold text-xl">Resumo Consolidado</p>
        </div>
        <div class="flex">
            <div class="p-4 w-full">
                <p class="text-gray-600 text-sm">Valor Bruto Total</p>
                <p class="font-bold text-xl">{{ resume.total }}</p>
                <!-- TODO: adicionar as corretoras e valores -->
            </div>
            <div class="p-4 w-full">
                <p class="text-gray-600 text-sm">Imposto Retido (IR)</p>
                <p class="font-bold text-xl text-red-600">- {{ resume.tax }}</p>
                <span class="text-gray-400 text-xs">20% RF / 15% RV</span>
            </div>
            <div class="p-4 w-full">
                <p class="text-gray-600 text-sm">Taxa de Consultoria</p>
                <p class="font-bold text-xl text-yellow-600">- {{ resume.fee }}</p>
                <span class="text-gray-400 text-xs">0.5% sobre o liquido</span>
            </div>
            <div class="p-4 w-full text-green-700 bg-green-100">
                <p class="text-sm">Valor Líquido Final</p>
                <p class="font-bold text-xl">{{ netValue }}</p>
                <span class="text-green-500 text-xs">Pronto para saque</span>
            </div>
        </div>
    </div>
</template>
