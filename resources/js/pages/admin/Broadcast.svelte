<script>
    import { page, router } from "@inertiajs/svelte";
    import Icon from "@iconify/svelte";
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { BroadcastForm } from "@/widgets/admin/form";
    import { ListenerRequestGrid } from "@/widgets/admin/grid";

    $: ({ verify } = $page.props);

    function redirectToDashboard(){
        router.get("/painel/dashboard/");
    }
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <BroadcastForm title="Meus Programas" />
    <ListenerRequestGrid title="Pedidos Musicais" />
</Layout>

{#if verify.onair === true && verify.streamer === false}
    <section transition:fade={{duration: 500}} class="fixed inset-0 flex items-center justify-center p-2 lg:p-0 z-50 bg-[#00000036]">
        <div class="w-full lg:w-[20.9rem] p-5 rounded-lg bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="/img/default/onair.gif" alt="Bloqueador de tela" class="h-50 object-cover rounded-full"/>
            </div>
            <div class="mt-6 mb-4 bg-blue-skywave p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                Um locutor está no ar agora!
            </div>
            <div class="font-noto-sans  mb-3">
                Vou ser bem direta com você presta a atenção! Quando um locutor está no ar você não pode ver!
            </div>
            <div class="font-noto-sans mb-3">
                O que ele está fazendo é segredinho meu e dele! Volte quando não tiver ninguem...
            </div>
            <button on:click={()=>redirectToDashboard()} type="button" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-blue-ocean text-md font-bold font-noto-sans italic uppercase">
                <Icon icon="icon-park-outline:return" width="20" height="20" aria-hidden="true"/>Dashboard
            </button>
        </div>
    </section>
{/if}