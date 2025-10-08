<script>
    import { cast } from "@/store" // Import from store folder

</script>

{#if $cast}
    <section class="bg-blue-indigo">
        <div class="container border-t border-orange-amber py-4">
            <div class="flex">
                <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                    <img src="/icons/default/kbps.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                    {$cast.stream.plano_bitrate ?? "0 kbps"}
                </div>
                <div class="hidden gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase pl-6 pr-6 border-r border-r-[rgba(229,231,235,0.3)] lg:flex">
                    <img src="/icons/default/satelite.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                    {$cast.stream.status === "Ligado" ? "online" : "offline"}
                </div>
                <div class="flex gap-2 items-end font-noto-sans text-orange-amber text-xl uppercase lg:pl-6 lg:pr-6">
                    <img src="/icons/default/listeners.svg" alt="" aria-hidden="true" class="w-8 filter-blue-skywave" loading="lazy"/>
                    {$cast.stream.ouvintes_conectados ?? "0"} ouvintes
                </div>
            </div>
        </div>
    </section>
{/if}
