<script setup>
import AssetTypeBadge from "../Components/AssetTypeBadge.vue";

defineProps({
    assets: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="bg-white rounded-xl shadow">
        <div class="border-b border-gray-100 p-4">
            <p class="font-bold text-xl">Ativos do Cliente</p>
        </div>

        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2 px-4 bg-gray-100 text-gray-500 text-sm">Ativo</th>
                    <th class="text-left py-2 px-4 bg-gray-100 text-gray-500 text-sm">Tipo</th>
                    <th class="text-left py-2 px-4 bg-gray-100 text-gray-500 text-sm">Corretora</th>
                    <th class="text-right py-2 px-4 bg-gray-100 text-gray-500 text-sm">Valor</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="asset in assets" :key="asset.asset" class="border-t border-gray-100 text-sm">
                    <td class="text-left py-2 px-4">{{ asset.asset }}</td>
                    <td class="text-left py-2 px-4">
                        <AssetTypeBadge :asset-type="asset.type" />
                    </td>
                    <td class="text-left py-2 px-4 text-gray-600 text-sm">{{ asset.broker }}</td>
                    <td class="text-right py-2 px-4 text-gray-600 text-sm">{{ asset.value }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
