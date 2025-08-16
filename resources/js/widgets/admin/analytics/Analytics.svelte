<script>
    import { onMount } from 'svelte';

    import { cast } from "@/utils";

    // Resolve promisse to get cast data
    let data = null;
    onMount(async () => {
        try {
            data = await cast();
        } catch (error) {
            console.error('Error fetching cast data on akiba api:', error);
        }
    });
</script>

<section class="container border-t border-orange-amber bg-blue-indigo py-4">
    <div class="flex">
        <span class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
            <img src="/icons/kbps.svg" alt="kpbs icon" class="w-8 filter-blue-skywave" />
            {data?.['plano_bitrate'] ?? '0 kbps'} 
        </span>
        <span class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pl-6 pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
            <img src="/icons/satelite.svg" alt="satelite icon" class="w-8 filter-blue-skywave" />
            {data?.['status'] === 'Ligado' ? 'online' : 'offline'} 
        </span>
        <span class="flex gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase lg:pl-6 lg:pr-6">
            <img src="/icons/listeners.svg" alt="listeners icon" class="w-8 filter-blue-skywave" />
            {data?.['ouvintes_conectados'] ?? '0'} ouvintes
        </span>
    </div>
</section>
