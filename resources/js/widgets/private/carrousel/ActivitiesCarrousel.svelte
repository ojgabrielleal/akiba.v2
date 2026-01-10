<script>
    export let title = null; 

    import { router, page } from "@inertiajs/svelte";
    import { Section, CanRender } from "@/components/private/";
    import { scrollx } from "@/utils";

    $: ({ logged, activities } = $page.props);
    
    function createConfirmation(activityId) {
        router.post(`/painel/dashboard/activity/confirm/${activityId}`);
    }
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
        {#if activities.length > 0}
            {#each activities as item}  
                {@const isParticipate = !item.confirmations.some(c => c.confirmer.id === logged.id)}
                {@const allowsConfirmations = item.allows_confirmations}
                <article class={['w-100 h-50 lg:w-[29rem] bg-blue-skywave flex-shrink-0 rounded-lg p-4 relative', 
                    {'bg-neutral-honeycream': allowsConfirmations},
                ]}>
                    <div class={['font-noto-sans font-black italic uppercase text-xl', 
                        {'text-blue-midnight': allowsConfirmations},
                        {'text-neutral-aurora': !allowsConfirmations}
                    ]}>
                        {item.responsible.nickname}
                    </div>
                    <div class={['font-noto-sans text-sm line-clamp-5 mt-1', 
                        {'text-blue-midnight': allowsConfirmations},
                        {'text-neutral-aurora': !allowsConfirmations}
                    ]}>
                        {item.content}
                    </div>
                    {#if allowsConfirmations}
                        <div class="flex gap-2 absolute bottom-3 left-4">
                            {#each item.confirmations as confirmation}
                                <img
                                    src={confirmation.confirmer.avatar}
                                    alt={confirmation.confirmer.nickname}
                                    class="w-9 h-9 rounded-full bg-neutral-aurora"
                                    loading="lazy"
                                />
                            {/each}
                        </div>
                        <CanRender permission="activity.participate">
                            <button
                                type="button"
                                aria-label="Confirmar alerta"
                                class="w-[2rem] h-[2rem] bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer disabled:opacity-50"
                                on:click={() => createConfirmation(item.id)}
                                disabled={isParticipate}
                            >
                                <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                            </button>
                        </CanRender>
                    {/if}
                </article>
            {/each}
        {:else}
            <article class="w-100 h-50 lg:w-[29rem] bg-blue-cerulean opacity-50 flex-shrink-0 rounded-lg p-4 relative">
                <div class="font-noto-sans font-black italic uppercase text-neutral-aurora text-xl">
                    Aki-chan
                </div>
                <div class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                    Mais um dia normal e com a mesma bagunça de sempre, um monte de coisa para fazer mas... O pessoal da Akiba tá dormindo vê se pode isso!
                    Mas relaxa, fica calmo, quando eles acordarem e se algo acontecer serei a primeira a te avisar!
                </div>
            </article>
        {/if}
    </div>
</Section>
