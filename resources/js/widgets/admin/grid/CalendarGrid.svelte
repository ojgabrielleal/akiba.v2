<script>
    export let controls = false ;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";

    $: ({ calendar } = $page.props);

    const tags = [
        { label: "Programas", color: "var(--color-blue-skywave)" },
        { label: "Lives", color: "var(--color-purple-mystic)" },
        { label: "Youtube", color: "var(--color-red-crimson)" },
        { label: "Podcasts", color: "var(--color-green-forest)" },
        { label: "", color: "var(--color-blue-skywave)" },
        { label: "", color: "var(--color-blue-skywave)" },
        { label: "", color: "var(--color-blue-skywave)" }

    ];

    let week = [];

   $: if (calendar) {
        const labels = {
            sun: "Dom",
            mon: "Seg",
            tue: "Ter",
            wed: "Qua",
            thu: "Qui",
            fri: "Sex",
            sat: "Sáb",
        };

        week = Object.values(labels).map(label => ({
            day: label,
            items: calendar.filter(event => event.day === label)
        }));

        console.log('week', week);
    }
</script>

<Section title="Calendário">
    <!-- Tags -->
    <div class="w-full grid gap-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each tags as tag}
            <span class="h-10 text-neutral-aurora text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center" style="background-color: {tag.color};">
                {tag.label}
            </span>
        {/each}
    </div>

    <!-- Calendário -->
    <div class="w-full grid gap-5 mt-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
        {#each week as day}
            <div class="flex flex-col gap-2 w-full">
                <span class="text-neutral-aurora text-lg font-noto-sans text-center font-bold uppercase italic">
                    {day.day}
                </span>
                {#each day.items as item}
                    <div class="w-full 2xl:w-[12.7rem] rounded-lg pt-4 pl-4 pr-4 pb-3" style="background-color: {item.styles?.bg || 'var(--color-blue-skywave)'};">
                        <div class="flex items-center">
                            <div class="w-full font-noto-sans text-2xl text-center text-neutral-aurora uppercase">
                                {item.hour}
                            </div>
                        </div>
                        <div class="w-full font-noto-sans font-bold text-2xl text-center text-neutral-aurora italic mt-6 mb-6">
                            {item.content}
                        </div>
                        <div class={`flex justify-between ${controls ? "flex-row-reverse" : "flex-row"}`}>
                            {#if controls}
                                <div class="flex gap-2">
                                    <button aria-label="Editar" class="cursor-pointer">
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </button>
                                    <button aria-label="Editar" class="cursor-pointer">
                                        <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </button>
                                </div>
                            {/if}
                            <div class={`w-full font-noto-sans text-md text-neutral-aurora ${controls ? "text-start" : "text-end"}`}>
                                {item.user?.nickname}
                            </div>
                        </div>
                    </div>
                {/each}
            </div>
        {/each}
    </div>
</Section>
