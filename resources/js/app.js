import "./bootstrap";
import { createInertiaApp } from "@inertiajs/svelte";
import { mount } from "svelte";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./pages/**/*.svelte", { eager: true });
        return pages[`./pages/${name}.svelte`];
    },
    setup({ el, App, props, plugin }) {
        // Registro do sw
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registrado'))
                    .catch(err => console.log('Erro ao registrar service worker'));
            });
        }

        //Montagem da aplicação
        mount(App, { target: el, props });
    },
});
