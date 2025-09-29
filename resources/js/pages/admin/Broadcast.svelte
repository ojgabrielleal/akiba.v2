<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";

    import { BroadcastForm } from "@/widgets/admin/form";
    import { ListenerRequestGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <BroadcastForm title="Meus Programas" />
    <ListenerRequestGrid title="Pedidos Musicais"/>
</Layout>
