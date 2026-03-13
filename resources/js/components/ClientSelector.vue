<script setup>
import { useClient } from "../composables/useClient";

const { setClientId } = useClient();
</script>

<template>
    <div>
        Cliente ID:
        <select
            name="client-id"
            id="client-id"
            class="border bg-white border-gray-300 rounded px-2 py-1"
            @input="setClientId($event.target.value)"
        >
            <option value="1">Cliente #1 (Normal)</option>
            <option value="2">Cliente #2 (Premium)</option>
        </select>
    </div>
</template>
