<script>
    export let publications = null

    import { router } from "@inertiajs/svelte";

    function pagination(page) {
        router.get("", { page: page },{
            preserveScroll: true,
        });
    }
</script>

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