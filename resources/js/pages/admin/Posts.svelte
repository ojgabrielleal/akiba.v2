<script>    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";
    import { Post as PostForm } from "@/widgets/admin/form";
    import { Posts as PostsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <Tabs items={TabsData.postsCategories}/>
        <div class="mt-10 xl:mt-25">
            <PostForm/>
        </div>
        <div class="mt-15">
            <PostsGrid title="Todas as matérias"/>
        </div>
    </Section>
</Layout>
    