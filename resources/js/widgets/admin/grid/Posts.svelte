<script>
    export let title = null;

    import { page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Post } from "@/components/admin/card"

    $:({ user, posts } = $page.props); 
</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#if posts.length === 0}
            <Post />
        {:else}
            {#each posts as item}
                <Post item={item} editable={item.user.id === user.id} />
            {/each}
        {/if}
    </div>        
</Section>