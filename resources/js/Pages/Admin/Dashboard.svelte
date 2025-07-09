<script>
    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Greating } from "@/Widgets/Hero";
    import { Alerts, Tasks } from "@/Widgets/Carrousel";
    import { Posts } from "@/Widgets/Grid";
    import { Calendar } from "@/Widgets/Calendar";
</script>

<Meta meta={{ title: "Dashboard" }} />
<Layout type="admin">
    <Greating/>
    <Alerts title="Avisos para a equipe"/>
    <Tasks title="Minhas Tarefas"/>
    <Posts title="Últimas Matérias"/>
    <Calendar title="Calendário"/>
</Layout>
