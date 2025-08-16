<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Post } from "@/components/admin/card"
    import { Button } from "@/components/admin/button";

    $:({ posts } = $page.props); 
    
    function pagination(page){
        router.get('', {page: page}, {
            preserveScroll: true
        });
    }
</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#if (posts.data && posts.data.length > 0)}
            {#each posts.data as item}
                <Post item={item} />
            {/each}
        {:else if (posts && posts.length > 0)}
            {#each posts as item}
                <Post item={item} />
            {/each}
        {:else}
            <Post />
        {/if}
    </div>        

    <div class="flex gap-5 mt-6">
    {#if posts.current_page}
        {#if posts.current_page === posts.last_page}
            <Button action={()=>{pagination(posts.current_page - 1 )}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl uppercase">
                Voltar
            </Button>
        {:else if posts.current_page === 1}
            <Button action={()=>{pagination(posts.current_page + 1)}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                Próximo
            </Button>
        {:else}
            <Button action={()=>{pagination(posts.current_page - 1 )}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl uppercase">
                Voltar
            </Button>
            <Button action={()=>{pagination(posts.current_page + 1)}} styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                Próximo
            </Button>
        {/if}
    {/if}
    </div>
</Section>