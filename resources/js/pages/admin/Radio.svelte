<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { ShowsGrid, ProgramScheduleGrid, RankingGrid, ListenerMonthGrid } from "@/widgets/admin/grid"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <ShowsGrid title="Programas cadastrados"/>
    <ProgramScheduleGrid title="Grade de programação"/>
    <RankingGrid title="Akiba Ranking"/>
    <ListenerMonthGrid title="Ouvinte da semana"/>
</Layout>
