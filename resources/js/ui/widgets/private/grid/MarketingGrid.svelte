<script>
    import { page, router, Link} from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Offcanvas } from "@/ui/components/private";
    import { MarketingForm } from "@/ui/widgets/private/form";

    $: ({ permissions, repositories } = $page.props);

    function deleteRepository(repositoryId){
        router.delete(`/painel/marketing/deactivate/repository/${repositoryId}`);
    }
</script>

{#if !permissions.view_all}
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
{/if}

<Section title="Tutoriais">
    <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
        {#if repositories?.tutorials.length > 0}
            {#each repositories?.tutorials as item}
                <article class="w-full bg-blue-skywave relative">
                    <Link href={item.file} target="_blank">
                        <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                        <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                            {item.name}
                        </div>
                    </Link>
                </article>
            {/each}
        {:else}
            <article class="w-full bg-blue-skywave relative opacity-50">
                <img src="https://placehold.co/600x400?text=Akiba" alt="" aria-hidden="true" class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                    Nada por aqui, até agora
                </div>
            </article>
        {/if}
    </div>
</Section>

<Section title="Instaladores">
    <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
        {#if repositories?.installers.length > 0}
            {#each repositories?.installers as item}
                <article class="w-full bg-blue-skywave relative">
                    <Link href={item.file} target="_blank">
                        <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                        <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                            {item.name}
                        </div>
                    </Link>
                </article>
            {/each}
        {:else}
            <article class="w-full bg-blue-skywave relative opacity-50">
                <img src="https://placehold.co/600x400?text=Hello+World" alt="" aria-hidden="true" class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                    Nada por aqui, até agora
                </div>
            </article>
        {/if}
    </div>
</Section>

<Section title="Pacotes e Modelos">
    <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
        {#if repositories?.packages.length > 0}
            {#each repositories?.packages as item}
                <article class="w-full bg-blue-skywave relative">
                    <Link href={item.file} target="_blank">
                        <img src={item.image} alt={item.name} class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                        <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                            {item.name}
                        </div>
                    </Link>
                </article>
            {/each}
        {:else}
            <article class="w-full bg-blue-skywave relative opacity-50">
                <img src="https://placehold.co/600x400?text=Hello+World" alt="" aria-hidden="true" class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                    Nada por aqui, até agora
                </div>
            </article>
        {/if}
    </div>
</Section>


{#if permissions.view_all}
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
        <div class="mb-[5rem] grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-x-4 gap-y-20">
                {#if repositories?.all.length > 0}
                    {#each repositories?.all as item}
                        <article class="w-full bg-blue-skywave relative">
                            <Link href={item.file} target="_blank">
                                <img src={item.image} alt={item.name}  class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                                <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                                    {item.name}
                                </div>
                            </Link>
                            <div class="absolute -bottom-9 right-0 flex flex-row gap-4">
                                <Offcanvas>
                                    <div class="cursor-pointer" slot="action" >
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                                    </div>
                                    <div slot="title">
                                        Editar conteúdo
                                    </div>
                                    <div slot="content" let:close>
                                        <MarketingForm repositoryId={item.id} close={close}/>
                                    </div>
                                </Offcanvas>
                                <button onclick={()=>deleteRepository(item.id)} class="cursor-pointer">
                                    <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-red-crimson" loading="lazy"/>
                                </button>
                            </div>
                        </article>
                    {/each}
                {:else}
                    <article class="w-full bg-blue-skywave relative opacity-50">
                        <img src="https://placehold.co/600x400?text=Hello+World" alt="" aria-hidden="true" class="w-full h-[12rem] object-cover aspect-square" loading="lazy"/>
                        <div class="p-2 text-neutral-aurora text-center font-noto-sans font-light">
                            Nada por aqui, até agora
                        </div>
                    </article>
                {/if}
            </div>
    </Section>
{/if}