<script>
    export let title = null;
    export let view = null;
    export let edit = null;

    import { router, page, Link } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";

    $:({ publications } = $page.props); 

    function pagination(page){
        router.get('', {page: page}, {
            preserveScroll: true
        });
    }
</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#if (publications.data?.length > 0)}
            {#each publications.data as item}
                <div class="w-full h-[14rem] lg:w-[18.2rem] flex-shrink-0 rounded-lg p-4 relative" style="background-color: {item?.styles?.bg ?? 'var(--color-blue-skywave)'}">
                    <span class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        {item.title}
                    </span>
                    <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <span class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                            {item?.user?.nickname}
                        </span>
                        <div class="flex gap-3">
                            <a href={`${view}${item.slug}`} aria-label="Visualizar" class="cursor-pointer">
                                <img src="/icons/eye.svg" alt="eye icon" class="w-5 filter-neutral-aurora"/>
                            </a>
                            {#if item.editable}
                                <Link href={`${edit}${item.slug}`} aria-label="Editar" class="cursor-pointer">
                                    <img src="/icons/edit.svg" alt="edit icon" class="w-4 filter-neutral-aurora"/>
                                </Link>
                            {/if}
                        </div>
                    </div>
                </div>
            {/each}
        {:else}
            <div class="w-full h-[14rem] lg:w-[18.2rem] flex-shrink-0 rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                <span class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                    Humano, conteúdo? Nani sore? Os preguiçosos da Akiba estão relaxando por aqui~ (｡♥‿♥｡) 🌸🍵💤
                </span>
                <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                    <span class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                        Aki-chan
                    </span>
                </div>
            </div>
        {/if}
    </div>        
       
    {#if publications.data >= 10}
        {#if publications.last_page > 1}
            <div class="flex gap-5 mt-6">
                {#if publications.current_page > 1}
                    <button on:click={() => pagination(publications.current_page - 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold">
                        Voltar
                    </button>
                {/if}
                {#if publications.current_page < publications.last_page}
                    <button on:click={() => pagination(publications.current_page + 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold">
                        Próximo
                    </button>
                {/if}
            </div>
        {/if}
    {/if}
</Section>