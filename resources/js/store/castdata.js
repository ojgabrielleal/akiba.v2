import axios from "axios";
import { writable } from 'svelte/store';

export const castdata = writable(null); 

function data() {
    axios.get('/api/cast/data')
    .then(response => {
        castdata.set(response.data); 
        return response.data;
    })
    .catch(error => {
        console.error('Erro ao buscar data:', error);
        return null;
    });
}

data();
setInterval(() => {
    data();
}, 30 * 1000);
