<script>    
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { PostForm } from "@/widgets/admin/form";
    import { PublicationsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Matérias" }} />
<Layout>
    <Section title="Criar matérias">
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
            <a href="/painel/materias" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Matérias
            </a>
            <a href="/painel/reviews" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Reviews
            </a>
            <a href="/painel/eventos" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                Eventos
            </a>
        </div>
        <div class="mt-10 xl:mt-25">
            <PostForm/>
        </div>
        <div class="mt-15">
            <PublicationsGrid title="Todas as matérias" view="https://akiba.com.br/materias/" edit="/painel/materias/"/>
        </div>
    </Section>
</Layout>
    