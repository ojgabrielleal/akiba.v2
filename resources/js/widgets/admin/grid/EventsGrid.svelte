<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";    

    $: ({ events } = $page.props);

    function deactivate(slug){
        router.patch(`/painel/medias/deactivate/event/${slug}`);
    }

</script>

<Section title="Eventos">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
        {#if events.length > 0}
            {#each events as item}
                <div class="flex flex-col gap-2">
                    <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                        <img class="w-full h-65 object-cover aspect-square brightness-50" src={item.cover} alt={`Evento ${item.title}`}/>
                        <div class="flex gap-2 absolute bottom-3 right-3">
                            <a href={`/painel/eventos/${item.slug}`} type="button" class="cursor-pointer" aria-label="Editar">
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                            </a>
                            <button on:click={()=>deactivate(item.slug)} type="button" class="cursor-pointer" aria-label="Desativar">
                                <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                            </button>
                        </div>
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        {item.address}
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        {item.dates}
                    </div>
                </div>
            {/each}
        {:else}
            <div class="bg-blue-cerulean opacity-50 flex flex-col gap-2">
                <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                    <img class="w-full h-65 object-cover aspect-square brightness-50" src="/img/default/default_landscape.webp" alt="" aria-hidden="true"/>
                </div>
                <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                    Guarabira - PR
                </div>
                <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                    Forever
                </div>
            </div>
        {/if}
    </div>
</Section>