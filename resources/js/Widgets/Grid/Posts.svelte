<script>
    export let title;

    import { page } from "@inertiajs/svelte";

    import { Section } from "@/Layouts";
    import { Post } from "@/Components/Card"

    $:({ user, posts } = $page.props); 

</script>

<Section title={title}>
    <div class="flex gap-5 overflow-x-auto flex-wrap">
        {#each posts as post}
            <Post data={post} editable={user.id === post.user.id} />
        {/each}
    </div>        
</Section>