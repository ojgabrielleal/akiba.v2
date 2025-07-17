<script>
    import { page } from "@inertiajs/svelte";
    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { Tabs } from "@/components/admin/tabs";

    // Json to tabs items 
    const tabs = [
        { label: "Matéria", styles: "border-4 border-solid border-[var(--color-blue-skywave)] rounded-xl text-[var(--color-blue-skywave)] text-xl uppercase", redirect: "/painel/materias/criar" },
        { label: "Review", styles: "border-4 border-solid border-[var(--color-purple-mystic)] rounded-xl text-[var(--color-purple-mystic)] text-xl uppercase", redirect: "/painel/materias/criar" },
        { label: "Eventos", styles: "border-4 border-solid border-[var(--color-orange-copper)] rounded-xl text-[var(--color-orange-copper)] text-xl uppercase", redirect: "/painel/materias/criar" },
    ];

</script>
<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <Tabs items={tabs}/>
    </Section>
</Layout>
    