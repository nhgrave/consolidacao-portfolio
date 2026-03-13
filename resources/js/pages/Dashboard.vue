<script setup>
import { ref, onMounted, watch } from "vue";
import { fetchPortFolio } from "../services/PortfolioService";
import DashboardResume from "../components/DashboardResume.vue";
import DashboardAssets from "../components/DashboardAssets.vue";
import DashboardCompliance from "../components/DashboardCompliance.vue";
import PortfolioSkeleton from "../components/PortfolioSkeleton.vue"
import ClientSelector from "../components/ClientSelector.vue";
import { useClient } from "../composables/useClient";

const assets = ref([]);
const resume = ref({});
const loading = ref(true);
const { clientId } = useClient();

watch(clientId, () => {
    loadPortfolio();
})

onMounted(loadPortfolio);

function loadPortfolio() {
    loading.value = true;

    fetchPortFolio({ clientId: clientId.value })
        .then(data => {
            assets.value = data.portfolio;
            resume.value = data.resume;
        })
        .catch(error => {
            console.error(error);
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>

<template>
    <div class="flex justify-between items-center mb-6">
        <div class="flex flex-col gap-1">
            <h1 class="font-bold text-2xl">Visão do Cliente</h1>
            <p class="text-gray-600">Consolidação de portfólio e auditoria</p>
        </div>

        <ClientSelector />
    </div>

    <PortfolioSkeleton v-if="loading" />

    <DashboardResume v-if="!loading" :resume="resume" class="mb-6" />

    <DashboardAssets v-if="!loading" :assets="assets" class="mb-6" />

    <DashboardCompliance v-if="!loading" class="mb-6" />
</template>
