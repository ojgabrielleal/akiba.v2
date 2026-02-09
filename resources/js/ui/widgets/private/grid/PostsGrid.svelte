<script>
    export let title;
    export let publications;
    export let user; 
        
    import { Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Pagination } from "@/ui/components/private"
    import { hasPermissions } from "@/utils";

    $: authorization = {
        canUpdate: hasPermissions(user, 'post.update'),
        canUpdateOwn: hasPermissions(user, 'post.update.own')
    }

</script>

<Section {title}>
    <div class="gap-6 grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5">
        {#if publications.data.length > 0}
            {#each publications.data as item}
                {@const canEditAdmin = authorization.canUpdate}
                {@const canEditOwn = authorization.canUpdateOwn && user.id === item.author.id}
                {@const isPublished = item.status === 'published'}
                {@const isRevision = item.status === 'revision'}
                {@const isSketch = item.status === 'sketch'}
                <article class={['w-full h-[14rem] rounded-lg p-4 relative', 
                    {'bg-blue-skywave': isPublished},
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
                            <Link href={`/materias/${item.slug}`} target="_blank" aria-label="Visualizar" class="cursor-pointer">
                                <img src="/svg/default/eye.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                            </Link>
                            {#if canEditAdmin || canEditOwn}
                                <Link href={`/painel/materias/${item.slug}`} aria-label="Editar" class="cursor-pointer disabled:opacity-50">
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
