import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";
import path from 'path'
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
        svelte(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['svelte', 'svelte/transition', 'svelte/store'],
                }
            }
        }
    }
});
