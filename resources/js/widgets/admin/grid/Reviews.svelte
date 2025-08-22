<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Review } from "@/components/admin/card"
    import { Button } from "@/components/admin/button";

    $:({ reviews } = $page.props); 

    function pagination(page){
        router.get('', {page: page}, {
            preserveScroll: true
        });
    }
</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#if (reviews.data && reviews.data.length > 0)}
            {#each reviews.data as item}
                <Review item={item} />
            {/each}
        {:else if (reviews && reviews.length > 0)}
            {#each reviews as item}
                <Review item={item} />
            {/each}
        {:else}
            <Review />
        {/if}
    </div>        

    <div class="flex gap-5 mt-6">
    {#if reviews.data.length > 10}
        {#if reviews.current_page}
            {#if reviews.current_page === reviews.last_page}
                <Button action={()=>{pagination(reviews.current_page - 1 )}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl uppercase">
                    Voltar
                </Button>
            {:else if reviews.current_page === 1}
                <Button action={()=>{pagination(reviews.current_page + 1)}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                    Próximo
                </Button>
            {:else}
                <Button action={()=>{pagination(reviews.current_page - 1 )}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl uppercase">
                    Voltar
                </Button>
                <Button action={()=>{pagination(reviews.current_page + 1)}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                    Próximo
                </Button>
            {/if}
        {/if}
    {/if}
    </div>
</Section>