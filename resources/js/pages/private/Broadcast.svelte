<script>
    import { page, router } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { BroadcastForm } from "@/ui/widgets/private/form";
    import { ListenerRequestGrid } from "@/ui/widgets/private/grid";

    $: ({ verify } = $page.props);

    function redirectToDashboard(){
        router.get("/painel/dashboard/");
    }
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    <BroadcastForm/>
    <ListenerRequestGrid/>
</Layout>

{#if verify.onair === true && verify.streamer === false}
    <section transition:fade={{duration: 500}} class="fixed inset-0 flex items-center justify-center p-2 lg:p-0 z-50 bg-[#00000036]">
        <div class="w-full lg:w-[20.9rem] p-5 rounded-lg bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="/img/default/bloquedOnair.gif" alt="Bloqueador de tela" class="h-50 object-cover rounded-full" loading="lazy"/>
            </div>
            <div class="mt-6 mb-4 bg-blue-skywave p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                Um locutor está no ar agora!
            </div>
            <div class="font-noto-sans  mb-3">
                Vou ser bem direta com você, presta atenção: quando um locutor está no ar… surpresa! Você não pode ver.
            </div>
            <div class="font-noto-sans mb-3">
                O que ele está fazendo é segredinho meu e dele! Volte quando não tiver ninguém... sabe, pra não estragar a magia.
            </div>
            <button on:click={()=>redirectToDashboard()} type="button" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-md text-blue-ocean font-bold font-noto-sans italic uppercase">
                <img src="/svg/default/return.svg" alt="" aria-hidden="true" class="w-5 filter-blue-ocean" loading="lazy"/>
                Dashboard
            </button>
        </div>
    </section>
{/if}