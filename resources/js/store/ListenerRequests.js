import axios from "axios";
import { writable } from 'svelte/store';

export const listenerRequests = writable({
    requests: null,
});

function fetchListenerRequests() {
    axios.get('/painel/locucao/list/listener/requests')
        .then((response) => {
            listenerRequests.update(current => ({ ...current, requests: response.data }));
        })
        .catch((error) => {
            console.error('Erro ao buscar pedidos de locução:', error);
        });
}

let interval;

export function startListenerRequestPolling() {
    if (!interval) {
        fetchListenerRequests();
        interval = setInterval(fetchListenerRequests, 60 * 1000);
    }
}

export function stopListenerRequestPolling() {
    if (interval) {
        clearInterval(interval);
        interval = null;
        listenerRequests.update(current => ({ ...current, requests: null }));
    }
}

export function refetchListenerRequests() {
    fetchListenerRequests();
}