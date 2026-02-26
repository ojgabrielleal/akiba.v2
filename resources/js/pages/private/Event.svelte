<script>    
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { EventForm } from "@/ui/widgets/private/form";
    import { EventGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Eventos" }} />
<Layout>
    <EventForm/>
    <EventGrid title="Todos os Eventos" view="https://akiba.com.br/eventos/" edit="/painel/eventos/"/>
</Layout>
    