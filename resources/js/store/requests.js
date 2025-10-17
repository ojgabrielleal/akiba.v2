import axios from "axios";
import { writable } from 'svelte/store';

export const requests = writable(null);

export function startPolling() {
    function fetchData() {
        return axios.get('/painel/locucao/requests')
            .then(response => {
                requests.set(response.data);
                return response.data;
            })
            .catch(error => {
                console.error(error);
                return null;
            });
    }

    // Fetch initial data
    fetchData();
    
    // Start polling
    const interval = setInterval(fetchData, 5 * 1000);
    
    // Return cleanup function
    return () => {
        clearInterval(interval);
        requests.set(null);
    };
}
