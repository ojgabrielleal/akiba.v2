<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/private";
    import { PodcastsForm } from "@/ui/widgets/private/form"
    import { PodcastsGrid } from "@/ui/widgets/private/grid"
</script>

<Meta meta={{ title: "Podcasts" }} />
<Layout>
    <PodcastsForm/>
    <PodcastsGrid/>
</Layout>