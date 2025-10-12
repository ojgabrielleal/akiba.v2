import axios from "axios";
import { writable } from 'svelte/store';

export const metadata = writable(null); 

function data() {
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

data();
setInterval(() => {
    data();
}, 30 * 1000);
