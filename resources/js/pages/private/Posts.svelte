<script>    
    import { Meta } from "@/meta";
    import { Layout,  } from "@/layouts/private";
    import { PostsForm } from "@/ui/widgets/private/form";
    import { PublicationsGrid } from "@/ui/widgets/private/grid";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <PostsForm/>
    <PublicationsGrid title="Todas as matérias" view="https://akiba.com.br/materias/" edit="/painel/materias/"/>
</Layout>
    