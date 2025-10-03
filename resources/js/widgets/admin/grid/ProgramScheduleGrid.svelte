<script>
    export let title = null;

    import { page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";    

    $: ({ program_schedule } = $page.props);

    let days = {
        "dom": "Domingo",
        "seg": "Segunda",
        "ter": "Terça",
        "qua": "Quarta",
        "qui": "Quinta",
        "sex": "Sexta",
        "sab": "Sábado"
    }
</script>

<Section title={title}>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-15 mt-6">
        {#each program_schedule as item}
            <div class="w-full">
                <img class="w-[10rem] mb-3" src={item.show.image} alt={item.show.name}/>
                <div class="w-full rounded-md py-3 px-4 bg-neutral-aurora relative mb-2">
                    <div class="text-blue-skywave text-md font-noto-sans uppercase">
                        <span class="font-bold">Com:</span>
                        {item.show.user.nickname}
                    </div>
                    <img class="w-[9rem] aspect-square absolute right-0 bottom-0" src={item.show.user.avatar} alt={item.show.user.nickname}>
                </div>
                <div class="w-full rounded-md py-2 px-4 bg-neutral-aurora flex justify-between mb-2">
                    <span class="block text-black font-noto-sans font-bold uppercase italic">
                        {days[item.day]}
                    </span>
                    <span class="block text-black font-noto-sans uppercase">
                        {item.time}
                    </span>
                </div>
            </div>
        {/each}
    </div>
</Section>
