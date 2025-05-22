import "./bootstrap";
import { createInertiaApp } from "@inertiajs/svelte";
import { mount } from "svelte";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.svelte", { eager: true });
        return pages[`./Pages/${name}.svelte`];
    },
    setup({ el, App, props, plugin }) {
        mount(App, { target: el, props });
    },
});
