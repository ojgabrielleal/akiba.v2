<script>
    import { router, page, Link } from "@inertiajs/svelte";
    import { Section } from "@/components/private/";

    $: ({ podcasts } = $page.props);

    function deactivatePodcast(id){
        router.delete(`/painel/podcasts/deactivate/${id}`);
    }
</script>

<Section title="Todos os podcasts">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 lg:gap-y-10 lg:gap-x-5">
            {#if podcasts.data?.length > 0}
                {#each podcasts.data as item}
                    <article>
                        <div class="aspect-square">
                            <img class="w-full h-full rounded-lg" src={item.image} alt={`Capa do podcast ${item.title}`}/>
                        </div>
                        <dl class="flex justify-between mt-3">
                            <dt class="text-orange-amber text-2xl font-noto-sans font-bold uppercase italic">
                                S{item.season}-EP{item.episode}
                            </dt>
                            <dd class="flex items-center gap-3">
                                {#if item.actions.editable}
                                    <Link href={`/painel/podcasts/${item.slug}`} aria-label="Editar">
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </Link>
                                {/if}
                                {#if item.actions.deactivate}
                                    <button on:click={()=>deactivatePodcast(item.id)} class="cursor-pointer" aria-label="Desativar">
                                        <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-red-crimson" loading="lazy"/>
                                    </button>
                                {/if}
                            </dd>
                        </dl>
                    </article>
                {/each}
            {:else}
                <article class="opacity-50">
                    <div class="aspect-square">
                        <img class="w-full h-full object-cover object-center rounded-lg" src="/img/default/defaultLandscape.webp" alt="" aria-hidden="true"/>
                    </div>
                    <div class="flex justify-between mt-3">
                        <div class="text-orange-amber text-2xl font-noto-sans font-bold uppercase italic">
                            S00-EP00
                        </div>
                    </div>
                </article>
            {/if}
        </div>
        {#if podcasts.per_page >= 10}
            {#if podcasts?.last_page > 1}
                <div class="flex gap-5 mt-6">
                    {#if podcasts.current_page > 1}
                        <button on:click={() => pagination(podcasts.current_page - 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold">
                            Voltar
                        </button>
                    {/if}
                    {#if podcasts.current_page < podcasts.last_page}
                        <button on:click={() =>pagination(podcasts.current_page + 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold">
                            Próximo
                        </button>
                    {/if}
                </div>
            {/if}
        {/if}
    </Section>