<script>
    export let title = null;

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Preview } from "@/components/admin";

    $: ({ listener_month } = $page.props);

    let image = null;
    function updateListenerMonth(){
        const formData = new FormData();
        formData.append('image', image);
        formData.append('listener_name', listener_month?.listener);
        formData.append('address', listener_month?.address);
        formData.append('favorite_program', listener_month?.onair.program.name);
        formData.append('quantity_of_requests', listener_month?.total);

        router.post('/painel/radio/create/listener_month', formData, {
            forceFormData: true
        });
    }
</script>

<Section title={title}>
    <div class="grid grid-cols-1 lg:grid-cols-2 pt-8">
        <dl class="grid grid-cols-2">
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans">
                    Nome:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month?.listener}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Mora em:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month?.address}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Número de pedidos feitos:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month?.total}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Programa preferido
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month?.onair.program.name}
                </dd>
            </div>
        </dl>
        <div class="flex gap-5 items-center justify-end">
            <div>
                <span class="text-orange-amber font-bold italic text-sm uppercase font-noto-sans block">
                    Imagem do ouvinte
                </span>
                <Preview size="w-[9rem] h-[9rem]" view="w-[9rem] h-[9rem]" oninput={(event) => (image = event.target.files[0])}/>
            </div>
            <button onclick={()=>updateListenerMonth()} class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic">
                Atualizar com novo ouvinte
            </button>
        </div>
    </div>
</Section>