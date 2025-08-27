<script>
    import { Meta } from "@/meta";
    import { Layout, Section } from "@/layouts/admin";
    import { ReviewForm } from "@/widgets/admin/form";
    import { PublicationsGrid } from "@/widgets/admin/grid";
</script>

<Meta meta={{ title: "Reviews" }} />
<Layout>
    <Section title="Criar review">
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
            <a href="/painel/materias" aria-label="Matérias">
                <button class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                    Matérias
                </button>
            </a>
            <a href="/painel/reviews" aria-label="Reviews">
                <button class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                    Reviews
                </button>
            </a>
            <a href="/painel/eventos" aria-label="Eventos">
                <button class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
                    Eventos
                </button>
            </a>
        </div>        
        <div class="mt-10 xl:mt-25">
            <ReviewForm />
        </div>
        <div class="mt-15">
            <PublicationsGrid title="Todos os reviews" view="https://akiba.com.br/reviews/" edit="/painel/reviews/" />
        </div>
    </Section>
</Layout>
