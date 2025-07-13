<script>
    import { onMount } from 'svelte';

    import { streaming } from "@/utils";

    // Resolve promisse to get streaming data
    let data = null;
    onMount(async () => {
        try {
            data = await streaming();
        } catch (error) {
            console.error('Error fetching streaming data on akiba api:', error);
        }
    });
</script>

{#if data}
    <section class="container border-t border-[var(--color-orange-amber)] bg-[var(--color-blue-indigo)] py-4">
        <div class="flex">
            <span class="flex gap-2 items-end font-noto-sans text-[var(--color-orange-amber)] text-xl uppercase pr-6 border-r border-r-[rgba(229,231,235,0.3)]">
                <img src="/icons/kbps.svg" alt="kpbs icon" class="w-8 color-filter-blue-skywave" />
                {data['plano_bitrate'] ? data['plano_bitrate'] : '0 kbps'} 
            </span>
            <span class="flex gap-2 items-end font-noto-sans text-[var(--color-orange-amber)] text-xl uppercase pl-6 pr-6 border-r border-r-[rgba(229,231,235,0.3)]">
                <img src="/icons/satelite.svg" alt="satelite icon" class="w-8 color-filter-blue-skywave" />
                {data['status'] === 'Ligado' ? 'online' : 'offline'} 
            </span>
            <span class="flex gap-2 items-end font-noto-sans text-[var(--color-orange-amber)] text-xl uppercase pl-6 pr-6">
                <img src="/icons/listeners.svg" alt="listeners icon" class="w-8 color-filter-blue-skywave" />
                {data['ouvintes_conectados'] ? data['ouvintes_conectados'] : '0'} ouvintes
            </span>
        </div>
    </section>
{/if}