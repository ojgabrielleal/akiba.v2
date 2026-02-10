<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ReviewsForm } from "@/ui/widgets/private/form";
    import { ReviewsGrid } from "@/ui/widgets/private/grid";

    $: ({ 
        user,
        reviews,
        review
    } = $page.props);
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
        <ReviewsForm 
            {review}
            {user}
        />
        <ReviewsGrid 
            title="Todos os reviews"
            {reviews}
            {user}
        />
</Layout>
