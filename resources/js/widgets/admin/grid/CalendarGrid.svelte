<script>
    export let title; 

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";

    $:({ calendar } = $page.props);

    // Tags from calendar
    const tags = [
        { label: 'Programas', color: 'var(--color-blue-skywave)' },
        { label: 'Lives', color: 'var(--color-purple-mystic)' },
        { label: 'Youtube', color: 'var(--color-red-crimson)' },
        { label: 'Podcasts', color: 'var(--color-green-forest)' },
        { label: '', color: 'var(--color-blue-skywave)' },
        { label: '', color: 'var(--color-blue-skywave)' },
        { label: '', color: 'var(--color-blue-skywave)' },
    ];

    // Weekdays labels and items
    let week = [];
    $: if(calendar){
        const labels = {
            sun: "Dom",
            mon: "Seg",
            tue: "Ter",
            wed: "Qua",
            thu: "Qui",
            fri: "Sex",
            sat: "Sáb",
        };

        week = Object.keys(labels).map((key) => ({
            day: labels[key],
            items: calendar[key] || [],
        }));
    }
</script>

{#if Object.keys(calendar || {}).length > 0}
    <Section title={title}>
        <div class="w-full grid gap-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
                {#each tags as tag}
                    <span class="h-10 text-neutral-aurora text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center" style="background-color: {tag.color}">
                        {tag.label}
                    </span>
                {/each}
            </div>
            <div class="w-full grid gap-5 mt-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
            {#each week as day}
                <div class="flex flex-col gap-3 w-full" id={day.id}>
                    <span class="text-neutral-aurora text-lg font-noto-sans text-center font-bold uppercase italic">
                        {day.day}
                    </span>
                    {#each day.items as item}
                        <div class="w-full rounded-lg pt-4 pl-4 pr-4 pb-3 mb-5 2xl:w-[12.7rem]" style="background-color: {item.styles.bg}">
                            <span class="w-full font-noto-sans text-2xl text-center text-neutral-aurora uppercase block">
                                {item.hour}H
                            </span>
                            <h1 class="w-full font-noto-sans font-bold text-2xl text-center text-neutral-aurora italic mt-3 mb-3">
                                {item.content}
                            </h1>
                            <span class="w-full font-noto-sans text-md text-end text-neutral-aurora block">
                                {item.user.nickname}
                            </span>
                        </div>
                    {/each}
                </div>
            {/each}
        </div>
    </Section>
{/if}   
