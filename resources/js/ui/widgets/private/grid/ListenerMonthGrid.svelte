<script>
    import { page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Offcanvas } from "@/ui/components/private";
    import { ListenerMonthForm } from "@/ui/widgets/private/form";

    $: ({ listenerMonthRegistered } = $page.props);
</script>

<Section title="Ouvinte do mês">
    <article class="grid grid-cols-1 lg:grid-cols-2">
        <div class="grid grid-cols-2">
            <dl class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans">
                    Nome:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listenerMonthRegistered?.listener || "Aki-Chan"}
                </dd>
            </dl>
            <dl class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Mora em:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listenerMonthRegistered?.address || "Shinjuku - Tokyo"}
                </dd>
            </dl>
            <dl class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Número de pedidos feitos:
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listenerMonthRegistered?.requests_total || "+8000"}
                </dd>
            </dl>
            <dl class="mb-8">
                <dt class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Programa preferido
                </dt>
                <dd class="block text-neutral-aurora font-noto-sans uppercase">
                    {listenerMonthRegistered?.favorite_show || "Plantão Ecchi"}
                </dd>
            </dl>
        </div>
        <div class="flex gap-5 items-center justify-end">
            <div>
                <div class="text-orange-amber font-bold italic text-sm uppercase font-noto-sans block">
                    Imagem do ouvinte
                </div>
                <image src={listenerMonthRegistered?.image ?? "/img/default/defaultAvatarFull.webp"} alt="Imagem do ouvinte" class="w-[9rem] h-[9rem] bg-gray-600 rounded-lg"/>
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
    </article>
</Section>