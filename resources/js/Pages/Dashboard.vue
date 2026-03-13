<script setup>
import { ref, onMounted } from "vue";
import { getPortfolio } from "../Services/api";
import DashboardResume from "../Components/DashboardResume.vue";
import DashboardAssets from "../Components/DashboardAssets.vue";
import DashboardCompliance from "../Components/DashboardCompliance.vue";

const assets = ref([]);
const resume = ref({});
const loading = ref(true);

onMounted(async () => {
    try {
        const data = await getPortfolio(1);
        assets.value = data.portfolio;
        resume.value = data.resume;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <div class="flex justify-between items-center mb-6">
        <div class="flex flex-col gap-1">
            <h1 class="font-bold text-2xl">Visão do Cliente</h1>
            <p class="text-gray-600">Consolidação de portfólio e auditoria</p>
        </div>

        <div>
            Cliente ID:
            <select name="client-id" id="client-id" class="border bg-white border-gray-300 rounded px-2 py-1">
                <option value="1">Cliente #1 (Normal)</option>
                <option value="2">Cliente #2 (Premium)</option>
            </select>
        </div>
    </div>

    <DashboardResume v-if="!loading" :resume="resume" class="mb-6" />

    <DashboardAssets v-if="!loading" :assets="assets" class="mb-6" />

    <DashboardCompliance v-if="!loading" class="mb-6" />
</template>
