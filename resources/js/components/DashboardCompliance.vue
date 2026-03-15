<script setup>
import { computed, onMounted, ref } from "vue";
import { useClient } from "../composables/useClient";
import { useI18n } from "../composables/useI18n";
import { generateReport, fetchReport } from "../services/PortfolioService";
import Loader from "./Loader.vue";
import Modal from "./Modal.vue";
import { formatCurrency } from "../utils/Currency";
import { formatDateTime } from "../utils/DateTime";

const { clientId } = useClient();
const { t } = useI18n();

const report = ref();
const polling = ref(null);
const showReportModal = ref(false);

const hasReport = computed(() => {
    return Object.keys(report.value || {}).length > 0;
});

const isGenerating = computed(() => {
    return ['pending', 'processing'].includes(report.value?.status);
});

const isCompleted = computed(() => {
    return report.value?.status === 'completed';
});

const netValue = computed(() => {
    return report.value?.total - report.value?.tax - report.value?.fee;
});

onMounted(() => {
    startPolling();
});

function generateReportHandler() {
    generateReport({ clientId: clientId.value })
        .then(response => {
            report.value = response;

            startPolling();
        });
}

function startPolling() {
  polling.value = setInterval(async () => {

    fetchReport({ clientId: clientId.value })
        .then((response) => {
            report.value = response;
        })
        .finally(() => {
            if (!hasReport.value || report.value?.status === 'completed' || report.value?.status === 'failed') {
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
            <span v-if="hasReport" :class="`status-badge status-${report.status} flex items-center gap-2`">
                <Loader v-if="isGenerating" />
                {{ t(`report.status.${report.status}`) }}
            </span>

            <button
                class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition cursor-pointer max-w-50 disabled:opacity-50 disabled:cursor-not-allowed"
                @click="generateReportHandler"
                :disabled="isGenerating"
            >
                Gerar Relatório de Auditoria
            </button>

            <button
                v-if="isCompleted"
                class="bg-green-300 text-green-800 px-4 py-2 rounded-lg text-sm hover:bg-green-400 transition cursor-pointer max-w-50"
                @click="showReportModal = true"
            >
                Visualizar Relatório
            </button>
        </div>

        <Modal :show="showReportModal" @close="showReportModal = false">
            <div class="flex flex-col items-center gap-1 mb-4">
                <h3 class="text-2xl font-bold">Consolidação de Portifólio</h3>
                <p class="text-sm text-gray-500">Documento oficial gerado pelo sistema de auditoria</p>
            </div>

            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <span class="text-gray-500 text-sm">Valor Bruto Total</span>
                <span>{{ formatCurrency(report.total) }}</span>
            </div>

            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <span class="text-gray-500 text-sm">Imposto Retido na Fonte (IR)</span>
                <span class="text-red-600">- {{ formatCurrency(report.tax) }}</span>
            </div>

            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <span class="text-gray-500 text-sm">Taxa de Consultoria (0.5%)</span>
                <span class="text-yellow-600">- {{ formatCurrency(report.fee) }}</span>
            </div>

            <div class="flex justify-between items-center bg-green-100 p-4 rounded">
                <span class="text-sm">Valor Líquido Final</span>
                <span class="text-xl font-bold text-green-900">{{ formatCurrency(netValue) }}</span>
            </div>

            <div class="border-b border-gray-200 mt-6 mb-4"></div>

            <div class="text-center text-gray-500 text-xs">
                <p>Relatório gerado em {{ formatDateTime(report.updated_at) }}</p>
                <p>Clube do Valor - Todos os direitos reservados</p>
            </div>

        </Modal>
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
