import { router } from "@inertiajs/svelte";

export function confirmActivityParticipant(activity){
    router.post(`/painel/dashboard/activity/${activity}/confirm`);
}
