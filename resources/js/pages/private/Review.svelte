<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ReviewForm } from "@/ui/widgets/private/form";
    import { ReviewGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <ReviewForm />
    <ReviewGrid title="Todos os reviews"/>
</Layout>
