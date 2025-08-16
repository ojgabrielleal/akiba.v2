<script>    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Post } from "@/widgets/admin/form";
    import { Posts } from "@/widgets/admin/grid";

    import TabsData from "@/data/admin/tabs";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <Tabs items={TabsData.postsCategories}/>
        <div class="mt-10 xl:mt-25">
            <Post/>
        </div>
        <div class="mt-15">
            <Posts title="Todas as matérias"/>
        </div>
    </Section>
</Layout>
    