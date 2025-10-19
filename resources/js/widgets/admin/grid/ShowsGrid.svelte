<script>
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Offcanvas } from "@/components/admin";
    import { ShowsForm } from "@/widgets/admin/form";

    $: ({ shows } = $page.props);

    function deactivateShow(id){
        router.patch(`/painel/radio/deactivate/show/${id}`);
    }
</script>

<div class="flex justify-center mb-10">
    <Offcanvas>
        <div class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic" slot="action" >
            Cadastrar programa
        </div>
        <div slot="title">
            Novo programa
        </div>
        <div slot="content" let:close>
            <ShowsForm {close}/>
        </div>
    </Offcanvas>
</div>
{#if shows?.length > 0}
    <Section title="Programas Cadastrados">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-20 mt-6">
            {#each shows as item}
                <article class="w-full flex justify-center lg:justify-start gap-4">
                    <img src={item.image} alt={item.name} class="w-60 transition duration-300 ease-in-out" loading="lazy"/>
                    <div class="flex flex-wrap lg:flex-col gap-5 mt-2 lg:mt-0">
                        <Offcanvas>
                            <div class="w-5 h-5 text-blue-skywave cursor-pointer" slot="action">
                                <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-blue-skywave" loading="lazy"/>
                            </div>
                            <div slot="title">
                                Atualizar programa
                            </div>
                            <div slot="content" let:close>
                                <ShowsForm {close} show_id={item.id}/>
                            </div>
                        </Offcanvas>
                        <button class="w-5 h-5 cursor-pointer" aria-label="Desativar programa" on:click={() => deactivateShow(item.id)}>
                            <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-red-crimson" loading="lazy"/>
                        </button>
                    </div>
                </article>
            {/each}
        </div>
    </Section>
{/if}