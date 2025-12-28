<script>
    import { router, page, Link } from "@inertiajs/svelte";
    import { Section } from "@/layouts/private/";    

    $: ({ events } = $page.props);

    function deactivateEvent(slug){
        router.delete(`/painel/medias/deactivate/event/${slug}`);
    }
</script>

<Section title="Eventos">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
        {#if events.data?.length > 0}
            {#each events.data as item}
                <article class="flex flex-col gap-2">
                    <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                        <img class="w-full h-65 object-cover aspect-square brightness-50" src={item.cover} alt={`Evento ${item.title}`}/>
                        <div class="flex gap-4 absolute bottom-3 right-3">
                            {#if item.actions.editable}
                                <Link href={`/painel/eventos/${item.slug}`} type="button" class="cursor-pointer" aria-label="Editar">
                                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                </Link>
                            {/if}
                            {#if item.actions.deactivate}
                                <button on:click={()=>deactivateEvent(item.id)} type="button" class="cursor-pointer" aria-label="Desativar">
                                    <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                </button>
                            {/if}
                        </div>
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        {item.address}
                    </div>
                    <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                        {item.dates}
                    </div>
                </article>
            {/each}
        {:else}
            <article class="bg-blue-cerulean opacity-50 flex flex-col gap-2">
                <div class="h-65 bg-blue-skywave rounded-sm relative overflow-hidden">
                    <img class="w-full h-65 object-cover aspect-square brightness-50" src="/img/default/defaultLandscape.webp" alt="" aria-hidden="true"/>
                </div>
                <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                    Shinjuku - Tokyo
                </div>
                <div class="rounded-sm bg-orange-amber py-2 text-neutral-aurora text-center font-noto-sans font-semibold">
                    Amanhã
                </div>
            </article>
        {/if}
    </div>
    {#if events.per_page >= 10}
        {#if events?.last_page > 1}
            <div class="flex gap-5 mt-6">
                {#if events.current_page > 1}
                    <button on:click={() => pagination(events.current_page - 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold">
                        Voltar
                    </button>
                {/if}
                {#if events.current_page < events.last_page}
                    <button on:click={() =>pagination(events.current_page + 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold">
                        Próximo
                    </button>
                {/if}
            </div>
        {/if}
    {/if}
</Section>