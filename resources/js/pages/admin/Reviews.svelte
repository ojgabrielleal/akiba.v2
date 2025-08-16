<script>    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Post as FormPost } from "@/widgets/admin/form";

    import TabsData from "@/data/admin/Tabs";

</script>
<Meta meta={{ title: "Reviews" }} />
<Layout>
    <Section title="Criar review">
        <Tabs items={TabsData.postsCategories}/>
        <div class="mt-10 xl:mt-25">
            <FormPost/>
        </div>
    </Section>
</Layout>
    