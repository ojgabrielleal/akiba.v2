<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { PostsForm } from "@/ui/widgets/private/form";
    import { PublicationsGrid } from "@/ui/widgets/private/grid";

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
    />
    <PublicationsGrid 
        title="Todas as matérias" 
        model="materias" 
        unrestricted={user.roles.filter(item => item.name === 'administrator')}
        {publications}    
        {user}
    />
</Layout>
