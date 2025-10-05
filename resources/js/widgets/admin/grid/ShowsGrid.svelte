<script>
    export let title = null;

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Offcanvas } from "@/components/admin";
    import { ShowForm } from "@/widgets/admin/form";
    import Icon from "@iconify/svelte";

    $: ({ shows } = $page.props);

    function deactivateShow(id){
        router.patch(`/painel/radio/deactivate/show/${id}`);
    }
</script>

<Section {title}>
    <Offcanvas>
        <div slot="action" class="flex justify-center mb-10">
            <div class="cursor-pointer w-[15rem] py-2  border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-lg font-bold font-noto-sans italic uppercase">
                Cadastrar programa
            </div>
        </div>
        <div slot="title">
            Novo programa
        </div>
        <div slot="content" let:close>
            <ShowForm {close}/>
        </div>
    </Offcanvas>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-20 mt-6">
        {#each shows as item}
            <article class="w-full flex justify-center lg:justify-start gap-4">
                <img src={item.image} alt={item.name} class={`w-60 transition duration-300 ease-in-out ${item.is_active ? "opacity-100" : "opacity-50"}`}/>
                <div class="flex flex-wrap lg:flex-col gap-5 mt-2 lg:mt-0">
                    <Offcanvas>
                        <div class="text-blue-skywave cursor-pointer" slot="action">
                            <Icon icon="solar:pen-bold" width="24" height="24" />
                        </div>
                        <div slot="title">
                            Atualizar programa
                        </div>
                        <div slot="content" let:close>
                            <ShowForm {close} show_id={item.id}/>
                        </div>
                    </Offcanvas>
                    <button class="cursor-pointer text-red-crimson" aria-label="Desativar programa" onclick={() => deactivateShow(item.id)}>
                        <Icon icon="iconamoon:trash-fill" width="24" height="24" aria-hidden="true" />
                    </button>
                </div>
            </article>
        {/each}
    </div>
</Section>