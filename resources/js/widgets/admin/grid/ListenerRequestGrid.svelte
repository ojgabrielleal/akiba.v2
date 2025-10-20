<script>
    import { onMount, onDestroy } from "svelte";
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { listenerRequests, startListenerRequestPolling, stopListenerRequestPolling, refetchListenerRequests } from "@/store"

    $: ({ verify } = $page.props);

    onMount(() => {
       startListenerRequestPolling();
    });

    onDestroy(() => {
        stopListenerRequestPolling();
    })

    function markToAttended(id){
        router.patch(`/painel/locucao/requests/attended/${id}`, {}, {
            onSuccess: ()=>{
                refetchListenerRequests();
            }
        })
    }

    function markToCanceled(id){
        router.patch(`/painel/locucao/requests/canceled/${id}`, {}, {
            onSuccess: ()=>{
                refetchListenerRequests();
            }
        })
    }

    function changeStatus(){
        router.patch("/painel/locucao/requests/status")
    }
</script>

{#if verify.onair === true && verify.streamer === true}
    <Section title="Pedidos musicais">
        <div class="flex justify-center">
            {#if verify.listener_request}
                <button on:click={() => changeStatus()} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-neutral-honeycream rounded-xl text-neutral-honeycream text-xl font-bold font-noto-sans italic uppercase">
                    Parar de receber
                </button>
            {:else}
                <button on:click={() => changeStatus()} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    Começar a receber
                </button>
            {/if}
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 mt-10">
            {#each $listenerRequests.requests as item}
                <article class={`w-full lg:w-[23.6rem] rounded-lg p-3 ${item.status === "attended" ? "bg-green-forest" : item.status ==="canceled" ? "bg-red-crimson" : "bg-blue-skywave"}`}>
                    <div class="w-70 flex items-center gap-1.5 text-neutral-aurora text-[1.2rem] font-noto-sans font-bold italic truncate">
                        <img src="/svg/default/profile.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
                        {item.listener}
                    </div>
                    <div class="w-70 mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans truncate">
                        <img src="/svg/default/gps.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
                        {item.address}
                    </div>
                    <div class="mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans">
                        <img src="/svg/default/ip.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
                        {item.listener_ip}
                    </div>
                    <div class="flex items-center justify-center w-full mt-5 mb-5">
                        <div class="relative w-full">
                            <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img src="/svg/default/music.svg" alt="" aria-hidden="true" class="w-6 filter-neutral-aurora"/>
                            </div>
                            <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <img src={item.music.image} alt={`Capa do anime ${item.music.production}`} class="w-15 h-15 rounded-lg object-cover object-top shrink-0" loading="lazy"/>
                        <div>
                            <div class="w-70 block text-neutral-aurora text-sm font-noto-sans truncate text-ellipsis">
                                Anime: {item.music.production}
                            </div>
                            <div class="w-70 block text-neutral-aurora text-sm font-noto-sans truncate text-ellipsis">
                                Artista: {item.music.artist}
                            </div>
                            <div class="w-70 block text-neutral-aurora text-sm font-noto-sans truncate text-ellipsis">
                                Música: {item.music.music}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full mt-5 mb-5">
                        <div class="relative w-full">
                            <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img src="/svg/default/telegram.svg" alt="" aria-hidden="true" class="w-7 filter-neutral-aurora"/>
                            </div>
                            <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                    <div class="h-15 line-clamp-3 text-neutral-aurora text-sm font-noto-sans mb-7">
                        {item.message}
                    </div>
                    <div class="flex justify-between">
                        <time class="flex items-center gap-1 text-neutral-aurora text-sm font-noto-sans font-bold italic">
                            <img src="/svg/default/clock.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
                            {new Date(item.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                        </time>
                        <div class="flex gap-3">
                            {#if item.status === "new"}
                                <button on:click={() => markToCanceled(item.id)} aria-label="Marcar como cancelado" class="cursor-pointer">
                                    <img src="/svg/default/close.svg" alt="" aria-hidden="true" class="w-6 filter-neutral-aurora"/>
                                </button>
                                <button on:click={() => markToAttended(item.id)} aria-label="Marcar como atendido"class="cursor-pointer">
                                    <img src="/svg/default/like.svg" alt="" aria-hidden="true" class="w-6 filter-neutral-aurora"/>
                                </button>
                            {/if}
                        </div>
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}
