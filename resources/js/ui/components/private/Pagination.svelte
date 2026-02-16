<script>
    export let pages;

    import { router } from "@inertiajs/svelte";

    const pagination = (page) => {
        router.get("", { page: page },{
            preserveScroll: true,
        });
    }
</script>

{#if pages.per_page >= 10}
    {#if pages?.last_page > 1}
        <div class="flex gap-5 mt-6">
            {#if pages.current_page > 1}
                <button on:click={() => pagination(pages.current_page - 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl italic uppercase font-noto-sans font-bold">
                    Voltar
                </button>
            {/if}
            {#if pages.current_page < pages.last_page}
                <button on:click={() =>pagination(pages.current_page + 1)} class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl italic uppercase font-noto-sans font-bold">
                    Próximo
                </button>
            {/if}
        </div>
    {/if}
{/if}