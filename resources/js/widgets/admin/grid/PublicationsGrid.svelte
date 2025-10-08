<script>
    export let title = null;
    export let view = null;
    export let edit = null;

    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";

    $: ({ publications } = $page.props);
    
    function pagination(page) {
        router.get("", { page: page },{
            preserveScroll: true,
        });
    }
</script>

<Section {title}>
    <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
        {#if publications?.data?.length > 0}
            {#each publications.data as item}
                <article class="w-full h-[14rem] rounded-lg p-4 relative" style="background-color: {item.styles.bg ?? 'var(--color-blue-skywave)'}">
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        {item.title}
                    </div>
                    <dl class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <dt class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                            {item?.user?.nickname}
                        </dt>
                        <dd class="flex gap-3">
                            <a href={`${view}${item.slug}`} aria-label="Visualizar" class="cursor-pointer">
                                <img src="/icons/default/eye.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                            </a>
                            {#if item.editable}
                                <a href={`${edit}${item.slug}`} aria-label="Editar" class="cursor-pointer">
                                    <img src="/icons/default/edit.svg" alt="" aria-hidden="true" class="w-4 filter-neutral-aurora" loading="lazy"/>
                                </a>
                            {/if}
                        </dd>
                    </dl>
                </article>
            {/each}
        {:else}
            <article class="w-full h-[14rem] rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                    Meu bem esse pessoal da akiba são um bando de preguiçosos! Cade as postagens?
                </div>
                <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                    <div class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                        Aki-chan
                    </div>
                </div>
            </article>
        {/if}
    </div>
    {#if publications.per_page >= 10}
        {#if publications?.last_page > 1}
            <div class="flex gap-5 mt-6">
                {#if publications.current_page > 1}
                    <button on:click={() => pagination(publications.current_page - 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold">
                        Voltar
                    </button>
                {/if}
                {#if publications.current_page < publications.last_page}
                    <button on:click={() =>pagination(publications.current_page + 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold">
                        Próximo
                    </button>
                {/if}
            </div>
        {/if}
    {/if}
</Section>
