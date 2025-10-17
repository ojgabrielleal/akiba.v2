import axios from "axios";
import { writable } from 'svelte/store';

export const metadata = writable(null); 

function fetchMetadata() {
    axios.get('/api/cast/metadata')
    .then(response => {
        metadata.set(response.data);
        return response.data;
    })
    .catch(error => {
        console.error(error);
        return null;
    });
}

let interval;
export function startMetadataPolling() {
    if (!interval) {
        fetchMetadata();
        interval = setInterval(fetchMetadata, 60 * 1000);
    }
}

export function stopMetadataPolling() {
    if (interval) {
        clearInterval(interval);
        interval = null;
    }
}
