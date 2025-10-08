import axios from "axios";
import { writable } from 'svelte/store';

// Create a writable store with an initial value of null
export const cast = writable(null);

const getData = async () => {
    try {
        const response = await axios.get('/api/cast/data');
        const data = { ...response.data, _updatedAt: Date.now() };
        // Set the store value, which will notify all subscribers
        cast.set(data);
        return data;
    } catch (err) {
        console.error(err);
        return null;
    }
};

// First, get the data. After it's done, set up the interval.
getData().finally(() => {
    // atualiza a cada 60s
    setInterval(getData, 60 * 1000);
});
