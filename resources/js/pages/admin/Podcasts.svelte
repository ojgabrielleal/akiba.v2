<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { PodcastsForm } from "@/widgets/admin/form"
    import { PodcastsGrid } from "@/widgets/admin/grid"
</script>

<Meta meta={{ title: "Podcasts" }} />
<Layout>
    <PodcastsForm/>
    <PodcastsGrid/>
</Layout>