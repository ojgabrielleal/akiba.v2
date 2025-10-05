<script>
    export let title = null;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Offcanvas } from "@/components/admin";

    $: ({ listener_month } = $page.props);
</script>

<Section title={title}>
    <Offcanvas>
        <div slot="action" class="flex justify-center mb-10">
            <div class="cursor-pointer w-[18rem] py-2  border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-lg font-bold font-noto-sans italic uppercase">
                Atualizar ouvinte do mês
            </div>
        </div>
        <div slot="title">
            Atualizar ouvinte do mês
        </div>
        <div slot="content" let:close>
            teste
        </div>
    </Offcanvas>
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
            <img src="#" alt="Avatar do ouvinte"/>
        </div>
    </div>
</Section>