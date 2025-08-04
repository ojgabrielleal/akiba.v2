<script>    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Post as FormPost } from "@/widgets/admin/form";
    import { Posts as ListPosts } from "@/widgets/admin/grid"

    import TabsData from "@/data/admin/Tabs";

</script>
<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <Tabs items={TabsData.postsCategories}/>
        <div class="mt-10 lg:mt-25">
            <FormPost/>
        </div>
        <div class="mt-15">
            <ListPosts title="Todas as matérias"/>
        </div>
    </Section>
</Layout>
    