<script>
    import { Section } from "@/layouts/admin";
    import { Offcanvas } from "@/components/admin";
    import Icon from "@iconify/svelte";
</script>

<Section title="Tutoriais">
    <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
        <div class="w-full bg-blue-skywave relative">
            <img src="/img/default/default_landscape.webp" alt="Instalador Windows" class="w-full max-h-[13rem] object-contain" />
            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                Teste
            </div>
            <div class="absolute -bottom-9 right-0 flex flex-row gap-4">
                <button>
                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                </button>
                <button class="cursor-pointer text-red-crimson">
                    <Icon icon="iconamoon:trash-fill" width="24" height="24" aria-hidden="true" />
                </button>
            </div>
        </div>
    </div>
</Section>
<Section title="Instaladores">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7">
        <div class="w-full bg-blue-skywave">
            <img src="/img/default/default_landscape.webp" alt="Instalador Windows" class="w-full max-h-[13rem] object-contain" />
            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                Teste
            </div>
        </div>
    </div>
</Section>
<Section title="Pacotes e Modelos">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7">
        <div class="w-full bg-blue-skywave">
            <img src="/img/default/default_landscape.webp" alt="Instalador Windows" class="w-full max-h-[13rem] object-contain" />
            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                Teste
            </div>
        </div>
    </div>
</Section>
<Section title="Todos os conteúdos">
    <div class="flex justify-center mt-5 mb-5">
        <Offcanvas>
            <div class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase" slot="action" >
                Upar conteúdo
            </div>
            <div slot="title">
                Novo conteúdo
            </div>
            <div slot="content" let:close>
                Teste
            </div>
        </Offcanvas>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7">
        <div class="w-full bg-blue-skywave">
            <img src="/img/default/default_landscape.webp" alt="Instalador Windows" class="w-full max-h-[13rem] object-contain" />
            <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                Teste
            </div>
        </div>
    </div>
</Section>