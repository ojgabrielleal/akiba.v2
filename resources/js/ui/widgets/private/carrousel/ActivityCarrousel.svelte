<script>
    export let title; 

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx, hasPermission } from "@/utils";

    $: ({ user, activities } = $page.props);
    
    let permissions = {
        'show_button_participate': hasPermission('activity.participate'),
    }

    const requestConfirmActivityParticipant = (activity) => {
        router.post(`/painel/dashboard/activity/${activity}/confirm`);
    }

</script>

{#if activities}
    <Section {title}>
        <div class="scroll-x overflow-x-auto flex gap-5 flex-nowrap" on:wheel={scrollx} role="group">
            {#if activities.data.length > 0}
                {#each activities.data as item}  
                    {@const showButtonParticipate = permissions.show_button_participate && !item.confirmations.some(conf => conf.confirmer.uuid === user.uuid)}
                    <article class={['w-100 h-50 lg:w-116 shrink-0 rounded-lg p-4 relative',
                        {'bg-neutral-honeycream': item.allows_confirmations},
                        {'bg-blue-skywave': !item.allows_confirmations}
                    ]}>
                        <div class={['font-noto-sans font-black italic uppercase text-xl', 
                            {'text-blue-midnight': item.allows_confirmations},
                            {'text-neutral-aurora': !item.allows_confirmations}
                        ]}>
                            {item.author.nickname}
                        </div>
                        <div class={['font-noto-sans text-sm line-clamp-5 mt-1',
                            {'text-blue-midnight': item.allows_confirmations},
                            {'text-neutral-aurora': !item.allows_confirmations}
                        ]}>
                            {item.content}
                        </div>
                        {#if item.allows_confirmations}
                            <div class="flex gap-2 absolute bottom-3 left-4">
                                {#each item.confirmations as item}
                                    <img
                                        src={item.confirmer.avatar}
                                        alt={item.confirmer.nickname}
                                        class="w-10 h-10 rounded-full bg-neutral-aurora object-cover object-top"
                                        loading="lazy"
                                    />
                                {/each}
                            </div>
                            {#if showButtonParticipate}
                                <button
                                    type="button"
                                    aria-label="Confirmar alerta"
                                    class="w-8 h-8 bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                                    on:click={() => requestConfirmActivityParticipant(item.uuid)}
                                >
                                    <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                                </button>
                            {/if}
                        {/if}
                    </article>
                {/each}
            {:else}
                <article class="w-100 h-50 lg:w-116 bg-blue-cerulean opacity-50 shrink-0 rounded-lg p-4 relative">
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
{/if}
