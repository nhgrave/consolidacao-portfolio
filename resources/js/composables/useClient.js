import { readonly, ref } from "vue";

const clientId = ref(1);

export function useClient() {
    function setClientId(id) {
        clientId.value = id;
    }

    return {
        clientId: readonly(clientId),
        setClientId,
    };
}
