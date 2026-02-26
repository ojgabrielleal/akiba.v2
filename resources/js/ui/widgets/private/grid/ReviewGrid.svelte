<script>
    export let title;
        
    import { page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Pagination } from "@/ui/components/private"

    $: ({ reviews } = $page.props);
</script>

{#if reviews}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
            {#if reviews.data.length > 0}
                {#each reviews.data as item}
                    <article class='w-full h-[14rem] rounded-lg p-4 relative bg-blue-skywave'>
                        <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                            {item.title}
                        </div>
                        <div class="flex justify-end gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                            <div class="flex gap-3">
                                <a href={`/reviews/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                    <img src="/svg/default/eye.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                </a>
                                <a href={`/painel/reviews/${item.uuid}`} aria-label="Editar" class="cursor-pointer disabled:opacity-50">
                                    <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-4 filter-neutral-aurora" loading="lazy"/>
                                </a>
                            </div>
                        </div>
                    </article>
                {/each}
            {:else}
                <article class="w-full h-[14rem] rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        Meu bem esse pessoal da akiba são um bando de preguiçosos! Cade as reviews?
                    </div>
                    <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                            Aki-chan
                        </div>
                    </div>
                </article>
            {/if}
        </div>
        <Pagination pages={reviews}/>
    </Section>
{/if}