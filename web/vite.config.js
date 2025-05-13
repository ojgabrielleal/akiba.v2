import { defineConfig } from 'vite';
import { svelte } from "@sveltejs/vite-plugin-svelte";
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        svelte(),
    ],
});
