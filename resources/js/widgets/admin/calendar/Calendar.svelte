<script>
    export let title; 

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Calendar } from "@/components/admin/card"

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
                    <span class="h-10 text-[var(--color-neutral-aurora)] text-lg font-noto-sans font-bold uppercase italic rounded-lg flex justify-center items-center" style="background-color: {tag.color}">
                        {tag.label}
                    </span>
                {/each}
            </div>
            <div class="w-full grid gap-5 mt-5 grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
            {#each week as day}
                <div class="flex flex-col gap-3 w-full" id={day.id}>
                    <span class="text-[var(--color-neutral-aurora)] text-lg font-noto-sans text-center font-bold uppercase italic">
                        {day.day}
                    </span>
                    {#if day.items.length === 0}
                        <Calendar />
                    {:else}
                        {#each day.items as item}
                            <Calendar item={item} category={item.category} />
                        {/each}
                    {/if}
                </div>
            {/each}
        </div>
    </Section>
{/if}   
