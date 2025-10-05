<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { ShowsGrid, ProgramScheduleGrid, RankingGrid, ListenerMonthGrid } from "@/widgets/admin/grid"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ShowsGrid/>
    <ProgramScheduleGrid/>
    <RankingGrid/>
    <ListenerMonthGrid/>
</Layout>
