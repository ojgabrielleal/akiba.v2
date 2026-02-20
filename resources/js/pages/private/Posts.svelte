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
    <PostsForm />
    <PostsGrid title="Todas as matérias" />
</Layout>
