import { ref } from "vue";

const locale = ref('pt-BR');

export function useI18n() {
    const messages = ref({
        'pt-BR': {
            brokers: {
                warnings: {
                    BROKER_ERROR: 'Ativos da corretora {{broker}} não puderam ser carregados.',
                }
            },
            report: {
                status: {
                    pending: 'Relatório Pendente',
                    processing: 'Processando Relatório',
                    completed: 'Relatório Concluído',
                    failed: 'Relatório Falhou',
                }
            }
        },
    });

    const t = (key, params = {}) => {
        const keys = key.split('.');
        let message = messages.value[locale.value];

        // Navega pela estrutura de mensagens usando as chaves
        for (const k of keys) {
            message = message[k];
            if (!message) return key;
        }

        // Substitui os parâmetros na mensagem
        for (const [param, value] of Object.entries(params)) {
            message = message.replace(`{{${param}}}`, value);
        }

        return message;
    };

    return { t, locale };
}
