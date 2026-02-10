<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { PostsForm } from "@/ui/widgets/private/form";
    import { PostsGrid } from "@/ui/widgets/private/grid";

    $: ({ 
        user,
        posts,
        post
    } = $page.props);

</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <PostsForm 
        {post}
        {user}
    />
    <PostsGrid 
        title="Todas as matérias" 
        {posts}    
        {user}
    />
</Layout>
