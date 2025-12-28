<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/private";
    import { ShowsGrid, ProgramScheduleGrid, RankingGrid, ListenerMonthGrid } from "@/widgets/private/grid"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ShowsGrid/>
    <ProgramScheduleGrid/>
    <RankingGrid/>
    <ListenerMonthGrid/>
</Layout>
