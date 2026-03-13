<script setup>
import { ref, onMounted } from "vue";
import { getPortfolio } from "../Services/api";

const portfolio = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const data = await getPortfolio(1);
        portfolio.value = data.portfolio;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <div>
        <h1>Visão do Cliente</h1>
        <p>Consolidação de portfólio e auditoria</p>
    </div>

    <div v-if="loading">
        Carregando portfólio...
    </div>

    <table v-else>
        <thead>
            <tr>
                <th>Ativo</th>
                <th>Tipo</th>
                <th>Corretora</th>
                <th>Valor</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="asset in portfolio" :key="asset.asset">
                <td>{{ asset.asset }}</td>
                <td>{{ asset.type }}</td>
                <td>{{ asset.broker }}</td>
                <td>{{ asset.value }}</td>
            </tr>
        </tbody>
    </table>
</template>
