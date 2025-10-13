<script>    
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { EventsForm } from "@/widgets/admin/form";
    import { PublicationsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Eventos" }} />
<Layout>
    <EventsForm/>
    <PublicationsGrid title="Todos os Eventos" view="https://akiba.com.br/eventos/" edit="/painel/eventos/"/>
</Layout>
    