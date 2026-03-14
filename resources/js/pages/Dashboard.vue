<script setup>
import { ref, onMounted, watch } from "vue";
import { fetchPortFolio } from "../services/PortfolioService";
import DashboardResume from "../components/DashboardResume.vue";
import DashboardAssets from "../components/DashboardAssets.vue";
import DashboardCompliance from "../components/DashboardCompliance.vue";
import PortfolioSkeleton from "../components/PortfolioSkeleton.vue"
import ClientSelector from "../components/ClientSelector.vue";
import { useClient } from "../composables/useClient";
import { useI18n } from "../composables/useI18n";

const assets = ref([]);
const resume = ref({});
const warnings = ref([]);
const loading = ref(true);
const { clientId } = useClient();
const { t } = useI18n();

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
            warnings.value = data.warnings;
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

    <div v-if="!loading && warnings.length" class="mb-6">
        <div v-for="(warning, index) in warnings" :key="index" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded p-4 mb-2">
            <p class="font-bold">Aviso</p>
            <p>{{ t(`brokers.warnings.${warning.code}`, { broker: warning.broker }) }}</p>
        </div>
    </div>

    <DashboardResume v-if="!loading" :resume="resume" class="mb-6" />

    <DashboardAssets v-if="!loading && assets.length" :assets="assets" class="mb-6" />

    <DashboardCompliance v-if="!loading" class="mb-6" />
</template>
