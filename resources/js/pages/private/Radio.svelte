<script>
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { ShowsGrid, ProgramScheduleGrid, RankingGrid, ListenerMonthGrid } from "@/ui/widgets/private/grid"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ShowsGrid/>
    <ProgramScheduleGrid/>
    <RankingGrid/>
    <ListenerMonthGrid/>
</Layout>
