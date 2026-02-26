<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { PostForm } from "@/ui/widgets/private/form";
    import { PostGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <PostForm />
    <PostGrid title="Todas as matérias" />
</Layout>
