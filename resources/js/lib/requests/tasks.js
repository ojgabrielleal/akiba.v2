import { router } from "@inertiajs/svelte";

export function markTaskCompleted(task) {
    router.post(`/painel/dashboard/task/${task}/complete`);
}