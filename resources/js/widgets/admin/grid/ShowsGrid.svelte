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
            <span  class="cursor-pointer w-[15rem] py-2  border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-lg font-bold font-noto-sans italic uppercase">
                Cadastrar programa
            </span>
        </div>
        <h1 slot="title">
            Novo programa
        </h1>
        <div slot="content" let:close>
            <ShowForm {close}/>
        </div>
    </Offcanvas>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-20 mt-6">
        {#each shows as item}
            <div class="w-full flex justify-center lg:justify-start gap-4">
                <img src={item.image} alt="logo" class={`w-60 transition duration-300 ease-in-out ${item.is_active ? "opacity-100" : "opacity-50"}`}/>
                <div class="flex flex-wrap lg:flex-col gap-5 mt-2 lg:mt-0">
                    <Offcanvas>
                        <span class="text-blue-skywave cursor-pointer" slot="action">
                            <Icon icon="solar:pen-bold" width="24" height="24" />
                        </span>
                        <h1 slot="title">
                            Atualizar programa
                        </h1>
                        <div slot="content" let:close>
                            <ShowForm {close} show_id={item.id}/>
                        </div>
                    </Offcanvas>
                    <button class="cursor-pointer text-red-crimson" onclick={() => deactivateShow(item.id)}>
                        <Icon icon="iconamoon:trash-fill" width="24" height="24" />
                    </button>
                </div>
            </div>
        {/each}
    </div>
</Section>