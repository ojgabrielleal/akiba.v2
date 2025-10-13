<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { ReviewsForm } from "@/widgets/admin/form";
    import { PublicationsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <ReviewsForm />
    <PublicationsGrid title="Todos os reviews" view="https://akiba.com.br/reviews/" edit="/painel/reviews/" />
</Layout>
