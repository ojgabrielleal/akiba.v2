<script>
    import { page } from "@inertiajs/svelte";
    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Post } from "@/widgets/admin/form";

    import TabsData from "@/data/admin/Tabs";

</script>
<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <Tabs items={TabsData.postsCategories}/>
        <div class="mt-25">
            <Post/>
        </div>
    </Section>
</Layout>
    