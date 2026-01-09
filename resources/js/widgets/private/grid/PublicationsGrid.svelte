<script>
    export let title = null;
    export let type = null;

    import { page, Link } from "@inertiajs/svelte";
    import { Section } from "@/layouts/private/";
    import { Pagination } from "@/components/private"
    import { policy } from "@/policies";

    $: ({ logged, publications } = $page.props);
</script>


{#if policy(logged.permissions, 'post.list')}
    <Section {title}>
        <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
            {#if publications.data.length > 0}
                {#each publications.data as item}
                    {@const isAuthor = policy(logged.permissions, 'post.update.own') && logged.nickname === item.author.nickname}
                    {@const isRevision = item.status === 'revision'},
                    {@const isSketch = item.status === 'sketch'}
                    <article class={['w-full h-[14rem] bg-blue-skywave rounded-lg p-4 relative', 
                        {'bg-orange-amber': isRevision},
                        {'bg-green-forest': isSketch}
                    ]}>
                        <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                            {item.title}
                        </div>
                        <dl class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                            <dt class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                                {item.author.nickname}
                            </dt>
                            <dd class="flex gap-3">
                                <Link href={`https://akiba.com.br/${type}/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                    <img src="/svg/default/eye.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                </Link>
                                {#if policy(logged.permissions, 'post.update') || isAuthor}
                                    <Link href={`https://akiba.com.br/painel/${type}/${item.slug}`} aria-label="Editar" class="cursor-pointer">
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-4 filter-neutral-aurora" loading="lazy"/>
                                    </Link>
                                {/if}
                            </dd>
                        </dl>
                    </article>
                {/each}
            {:else}
                <article class="w-full h-[14rem] rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                    <div class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
                        Meu bem esse pessoal da akiba são um bando de preguiçosos! Cade as postagens?
                    </div>
                    <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
                        <div class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                            Aki-chan
                        </div>
                    </div>
                </article>
            {/if}
        </div>
        <Pagination publications/>
    </Section>
{/if}