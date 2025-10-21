<script>
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin";
    import { Offcanvas } from "@/components/admin";
    import { MarketingForm } from "@/widgets/admin/form";

    $: ({ repositories } = $page.props);
    
    $:tutorials = repositories.filter(obj => obj.category === "tutorials");
    $:installers = repositories.filter(obj => obj.category === "installers");
    $:packages = repositories.filter(obj => obj.category === "packages");

    $:if(packages){
        console.log(packages)
    }

    function deleteRepository(repository_id){
        router.delete(`/painel/marketing/delete/repository/${repository_id}`);
    }
</script>

{#if tutorials.length > 0}
    <Section title="Tutoriais">
        <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#each tutorials as item}
                <a href={item.file} target="_blank" class="w-full bg-blue-skywave relative">
                    <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        {item.name}
                    </div>
                </a>
            {/each}
        </div>
    </Section>
{/if}

{#if installers.length > 0}
    <Section title="Instaladores">
        <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#each installers as item}
                <a href={item.file} target="_blank" class="w-full bg-blue-skywave relative">
                    <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        {item.name}
                    </div>
                </a>
            {/each}
        </div>
    </Section>
{/if}

{#if packages.length > 0}
    <Section title="Pacotes e Modelos">
        <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            {#each packages as item}
                <a href={item.file} target="_blank" class="w-full bg-blue-skywave relative">
                    <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                    <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                        {item.name}
                    </div>
                </a>
            {/each}
        </div>
    </Section>
{/if}

<Section title="Todos os conteúdos">
    <div class="flex justify-center mt-5 mb-15">
        <Offcanvas>
            <div class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase" slot="action" >
                Upar conteúdo
            </div>
            <div slot="title">
                Novo conteúdo
            </div>
            <div slot="content" let:close>
                <MarketingForm close={close}/>
            </div>
        </Offcanvas>
    </div>
    {#if repositories.length > 0}
        <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-x-4 gap-y-20">
            {#each repositories as item}
                <div class="w-full bg-blue-skywave relative">
                    <a href={item.file} target="_blank">
                        <img src={item.image} alt={item.name}  class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                        <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                            {item.name}
                        </div>
                    </a>
                    <div class="absolute -bottom-9 right-0 flex flex-row gap-4">
                        <Offcanvas>
                            <div class="cursor-pointer" slot="action" >
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                            </div>
                            <div slot="title">
                                Editar conteúdo
                            </div>
                            <div slot="content" let:close>
                                <MarketingForm repository_id={item.id} close={close}/>
                            </div>
                        </Offcanvas>
                        <button onclick={()=>deleteRepository(item.id)} class="cursor-pointer">
                            <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-red-crimson" loading="lazy"/>
                        </button>
                    </div>
                </div>
            {/each}
        </div>
    {/if}
</Section>