<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ReviewsForm } from "@/ui/widgets/private/form";
    import { PublicationsGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <ReviewsForm />
    <PublicationsGrid title="Todos os reviews" view="https://akiba.com.br/reviews/" edit="/painel/reviews/" />
</Layout>
