<script>    
    import { Meta } from "@/meta";
    import { Layout,  } from "@/layouts/admin";
    import { PostsForm } from "@/widgets/admin/form";
    import { PublicationsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <PostsForm/>
    <PublicationsGrid title="Todas as matérias" view="https://akiba.com.br/materias/" edit="/painel/materias/"/>
</Layout>
    