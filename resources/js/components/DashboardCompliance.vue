<script setup>
import { computed, onMounted, ref } from "vue";
import { useClient } from "../composables/useClient";
import { useI18n } from "../composables/useI18n";
import { generateReport, fetchReportStatus } from "../services/PortfolioService";

const { clientId } = useClient();
const { t } = useI18n();

const reportStatus = ref();
const polling = ref(null);

const isGenerating = computed(() => {
    return ['pending', 'processing'].includes(reportStatus.value);
});

const isCompleted = computed(() => {
    return reportStatus.value === 'completed';
});

onMounted(() => {
    startPolling();
});

function generateReportHandler() {
    generateReport({ clientId: clientId.value })
        .then(response => {
            reportStatus.value = response.status;

            startPolling();
        });
}

function startPolling() {
  polling.value = setInterval(async () => {

    fetchReportStatus({ clientId: clientId.value })
        .then((response) => {
            reportStatus.value = response.status;
        })
        .finally(() => {
            if (reportStatus.value === 'completed' || reportStatus.value === 'failed') {
                clearInterval(polling.value);
            }
        });
  }, 1000)
}
</script>

<template>
    <div class="flex bg-white rounded-xl shadow p-4">
        <div class="mr-auto">
            <p class="font-bold">Auditoria e Conformidade</p>
            <p class="text-gray-600 text-xs">Gere um relatório detalhado com o histórido de transações e cálculos de impostos.</p>
        </div>

        <div class="flex gap-2">
            <span v-if="reportStatus" :class="`status-badge status-${reportStatus}`">
                {{ t(`report.status.${reportStatus}`) }}
            </span>

            <button
                class="mt-4 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition cursor-pointer max-w-50"
                @click="generateReportHandler"
                :disabled="isGenerating"
            >
                Gerar Relatório de Auditoria
            </button>
        </div>
    </div>
</template>

<style scoped>
@reference "tailwindcss";

.status-badge {
    @apply px-4 py-1 rounded-full font-semibold flex items-center;
}

.status-pending {
    @apply bg-yellow-100 text-yellow-700;
}
.status-processing {
    @apply bg-yellow-100 text-yellow-700;
}
.status-completed {
    @apply bg-green-100 text-green-500;
}
.status-failed {
    @apply bg-red-100 text-red-600;
}
</style>
