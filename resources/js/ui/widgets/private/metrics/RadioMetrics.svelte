<script>
    import { page, usePoll } from "@inertiajs/svelte";

    $: ({ streaming } = $page.props);

    usePoll(60*1000);
</script>

<section class="bg-blue-indigo">
    <div class="container border-t border-orange-amber py-4">
        <div class="flex">
            <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                <img src="/svg/default/kbps.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                {streaming.bitrate}
            </div>
            <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pl-6 pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                <img src="/svg/default/satelite.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                {streaming.status}
            </div>
            <div class="flex gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase lg:pl-6 lg:pr-6">
                <img src="/svg/default/listeners.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                {streaming.listeners} Ouvintes
            </div>
        </div>
    </div>
</section>
