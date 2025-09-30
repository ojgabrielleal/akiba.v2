<script>
    import { page, router } from "@inertiajs/svelte";
    import Icon from "@iconify/svelte";
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { BroadcastForm } from "@/widgets/admin/form";
    import { ListenerRequestGrid } from "@/widgets/admin/grid";

    $: ({ verify } = $page.props);
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <BroadcastForm title="Meus Programas" />
    <ListenerRequestGrid title="Pedidos Musicais" />
</Layout>

{#if verify.onair === true && verify.streamer === false}
    <section class="fixed inset-0 flex items-center justify-center z-50 bg-[#000000e5]">
        <div class="w-1/5 p-5 rounded-lg bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="/img/default/onair.gif" alt="onair" class="h-50 object-cover rounded-full"/>
            </div>
            <h1 class="mt-6 mb-4 bg-blue-skywave p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                Um locutor está no ar agora!
            </h1>
            <p class="font-noto-sans text-justify mb-3">
                Vou ser bem séria com você, presta atenção! Quando um locutor está no ar você não pode ver!
            </p>
            <p class="font-noto-sans mb-3">
                O que ele está fazendo é segredinho meu e dele! Volte quando não tiver ninguem...
            </p>
            <button onclick={()=>router.get("/painel/dashboard/")} type="button" aria-label="ir pro dashboard" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-blue-ocean text-md font-bold font-noto-sans italic uppercase">
                <Icon icon="icon-park-outline:return" width="20" height="20" />Dashboard
            </button>
        </div>
    </section>
{/if}