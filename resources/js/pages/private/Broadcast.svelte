<script>
    import { page, router } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private";
    import { BroadcastForm } from "@/ui/widgets/private/form";
    import { SongRequestGrid } from "@/ui/widgets/private/grid";

    $: ({ user, onair } = $page.props);

    const redirectToDashboard = () => {
        router.get("/painel/dashboard/");
    }
</script>

<Meta meta={{ title: "Locução" }} />
<Layout>
    {#if onair.data.type === 'auto'}
        <BroadcastForm/>
    {/if}
    {#if onair.data.type === 'live' && onair.data.program.host.uuid === user.uuid}
        <SongRequestGrid/>
    {/if}
</Layout>

{#if (onair.data.type !== 'auto' || onair.data.type === 'live' || onair.data.type === 'record') && onair.data.program.host.uuid !== user.uuid}
    <section transition:fade={{duration: 500}} class="fixed inset-0 flex items-center justify-center p-2 lg:p-0 z-50 bg-black/20 backdrop-blur-sm">
        <div class="w-full lg:w-92 p-5 rounded-lg bg-neutral-aurora">
            <div class="flex justify-center">
                <img src="/img/broadcast/default/blocked.gif" alt="Bloqueador de tela" class="w-50 h-50 object-cover rounded-full" loading="lazy"/>
            </div>
            <div class="mt-6 mb-4 bg-blue-skywave p-3 rounded-xl text-center text-neutral-aurora font-noto-sans font-bold uppercase">
                PARE! Tem gente no ar!
            </div>
            <div class="font-noto-sans mb-3">
                Querendo derrubar {onair.data.program.host.gender === 'male' ? 'o amigo' : 'a amiga'} do ar? 
                Vai pro fim da fila e espera {onair.data.program.host.gender === 'male' ? 'ele' : 'ela'} acabar o programa antes de começar o seu!
            </div>
            <button on:click={()=>redirectToDashboard()} type="button" class="mt-5 flex gap-2 justify-center items-center cursor-pointer w-full py-2 px-6 border-2 border-blue-ocean rounded-xl text-md text-blue-ocean font-bold font-noto-sans italic uppercase">
                <img src="/svg/default/return.svg" alt="" aria-hidden="true" class="w-5 filter-blue-ocean" loading="lazy"/>
                Dashboard
            </button>
        </div>
    </section>
{/if}