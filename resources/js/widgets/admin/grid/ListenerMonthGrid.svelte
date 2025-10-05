<script>
    export let title = null;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Offcanvas } from "@/components/admin";
    import { ListenerMonthForm } from "@/widgets/admin/form";

    $: ({ listener_month_registered } = $page.props);
</script>

<Section title={title}>
    <div class="grid grid-cols-1 lg:grid-cols-2 pt-8">
        <dl class="grid grid-cols-2">
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans">
                    Nome:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month_registered?.listener || "Aki-Chan"}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Mora em:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month_registered?.address || "Shinjuku - Tokyo"}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Número de pedidos feitos:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month_registered?.requests_total || "+8000"}
                </dd>
            </div>
            <div class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Programa preferido
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listener_month_registered?.favorite_show || "Plantão Ecchi"}
                </dd>
            </div>
        </dl>
        <div class="flex gap-5 items-center justify-end">
            <div>
                <span class="text-orange-amber font-bold italic text-sm uppercase font-noto-sans block">
                    Imagem do ouvinte
                </span>
                <image src={listener_month_registered?.image ?? "https://media.tenor.com/aj2m5lTme9cAAAAe/darkville-rpg.png"} alt="Imagem do ouvinte" class="w-[9rem] h-[9rem] bg-gray-600 rounded-lg"/>
            </div>
            <Offcanvas>
                <div class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic" slot="action">
                    Atualizar ouvinte
                </div>
                <div slot="title">
                    Atualizar ouvinte do mês
                </div>
                <div slot="content" let:close>
                    <ListenerMonthForm {close}/>
                </div>
            </Offcanvas>
        </div>
    </div>
</Section>