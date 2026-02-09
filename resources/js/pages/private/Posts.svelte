<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { PostsForm } from "@/ui/widgets/private/form";
    import { PostsGrid } from "@/ui/widgets/private/grid";

    $: ({ 
        user,
        publications,
        publication
    } = $page.props);

</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <PostsForm 
        {publication}
        {user}
    />
    <PostsGrid 
        title="Todas as matérias" 
        {publications}    
        {user}
    />
</Layout>
