<script>
    export let title = null;

    import { page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Post } from "@/components/admin/card"

    $:({ posts } = $page.props); 

</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#if posts?.length === 0}
            <Post />
        {:else}
            {#each posts as item}
                <Post item={item}/>
            {/each}
        {/if}
    </div>        
</Section>