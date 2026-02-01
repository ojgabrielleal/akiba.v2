<script>    
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { EventsForm } from "@/ui/widgets/private/form";
    import { PublicationsGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Eventos" }} />
<Layout>
    <EventsForm/>
    <PublicationsGrid title="Todos os Eventos" view="https://akiba.com.br/eventos/" edit="/painel/eventos/"/>
</Layout>
    