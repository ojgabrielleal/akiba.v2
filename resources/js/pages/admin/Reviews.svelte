<script>
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Review } from "@/widgets/admin/form";
    import { Reviews } from "@/widgets/admin/grid";

    import TabsData from "@/data/admin/Tabs";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <Section title="Criar review">
        <Tabs items={TabsData.postsCategories} />
        <div class="mt-10 xl:mt-25">
            <Review />
        </div>
        <div class="mt-15">
            <Reviews title="Todos os reviews" />
        </div>
    </Section>
</Layout>
