<script>
    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Greating } from "@/Widgets/Hero";
    import { Alerts, Tasks, LastPosts } from "@/Widgets/Carrousel";
</script>

<Meta meta={{ title: "Dashboard" }} />
<Layout type="admin">
    <Greating/>
    <Alerts title="Avisos para a equipe"/>
    <Tasks title="Minhas Tarefas"/>
    <LastPosts title="Últimas Matérias"/>
</Layout>
