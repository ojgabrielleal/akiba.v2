<script>
    export let title = null;

    import { onMount, onDestroy } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import Icon from "@iconify/svelte";

    $: ({ verify, requests } = $page.props);

    // variável dummy para forçar re-render
    let tick = 0;
    let interval;

    onMount(() => {
        interval = setInterval(() => {
            tick += 1;
        }, 5000);
    });

    onDestroy(() => {
        clearInterval(interval);
    });
</script>

{#if verify.onair === true && verify.streamer === true}
    <Section {title}>
        <div class="flex justify-center">
            {#if verify.listener_request}
                <button onclick={() => router.patch("/painel/locucao/requests/status")} aria-label="parar de receber" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-neutral-honeycream rounded-xl text-neutral-honeycream text-xl font-bold font-noto-sans italic uppercase">
                    Parar de receber
                </button>
            {:else}
                <button onclick={() => router.patch("/painel/locucao/requests/status")} aria-label="começar a receber" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    Começar a receber
                </button>
            {/if}
        </div>
        <div class="flex flex-wrap gap-2 mt-10">
            {#each requests as item}
                {#key tick}
                    <div class={`w-[23.6rem] rounded-lg p-3 ${item.status === "finished" ? "bg-green-forest" : "bg-blue-skywave"}`}>
                        <span class="flex items-center gap-1.5 text-neutral-aurora text-[1.2rem] font-noto-sans font-bold italic">
                            <Icon icon="mdi:person-circle" width="20" height="20"/>
                            {item.listener}
                        </span>
                        <span class="mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans">
                            <Icon icon="tabler:map-pin-filled" width="20" height="20"/>
                            {item.address}
                        </span>
                        <span class="mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans">
                            <Icon icon="mdi:ip-network" width="20" height="20"/>
                            {item.listener_ip}
                        </span>
                        <div class="flex items-center justify-center w-full mt-5 mb-5">
                            <div class="relative w-full">
                                <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <Icon icon="streamline:ai-generate-music-spark-solid" width="24" height="24" class="text-neutral-aurora"/>
                                </div>
                                <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <img src={item.music.image} alt="capa da musica" class="w-15 h-15 rounded-lg object-cover object-top"/>
                            <div>
                                <span class="block text-neutral-aurora text-sm font-noto-sans">
                                    Anime: {item.music.production}
                                </span>
                                <span class="block text-neutral-aurora text-sm font-noto-sans">
                                    Artista: {item.music.artist}
                                </span>
                                <span class="block text-neutral-aurora text-sm font-noto-sans">
                                    Música: {item.music.music}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-full mt-5 mb-5">
                            <div class="relative w-full">
                                <div class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <Icon icon="basil:telegram-solid" width="24" height="24" class="text-neutral-aurora"/>
                                </div>
                                <div class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"></div>
                            </div>
                        </div>
                        <span class="h-15 line-clamp-3 text-neutral-aurora text-sm font-noto-sans mb-7">
                            {item.message}
                        </span>
                        <div class="flex justify-between">
                            <div class="flex items-center gap-1 text-neutral-aurora text-sm font-noto-sans font-bold italic">
                                <Icon icon="mdi:clock" width="24" height="24" />
                                {item.created_at.split("T")[1].split(":").slice(0, 2).join(":")}
                            </div>
                            {#if item.status === "new"}
                                <button onclick={() => router.patch(`/painel/locucao/listenerrequestfinished/${item.id}`)} class="cursor-pointer text-neutral-aurora">
                                    <Icon icon="material-symbols:save" width="24" height="24"/>
                                </button>
                            {/if}
                        </div>
                    </div>
                {/key}
            {/each}
        </div>
    </Section>
{/if}
