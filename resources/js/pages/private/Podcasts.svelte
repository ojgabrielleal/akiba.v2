<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/private";
    import { PodcastsForm } from "@/widgets/private/form"
    import { PodcastsGrid } from "@/widgets/private/grid"
</script>

<Meta meta={{ title: "Podcasts" }} />
<Layout>
    <PodcastsForm/>
    <PodcastsGrid/>
</Layout>