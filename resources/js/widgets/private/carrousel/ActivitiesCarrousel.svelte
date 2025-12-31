<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/private/";
    import { scrollx } from "@/utils";
    import { policy } from "@/policies";

    $: ({ logged, activities } = $page.props);
    
    function createConfirmation(activityId) {
        router.post(`/painel/dashboard/activity/confirm/${activityId}`);
    }
</script>

{#if policy(logged.permissions, 'activity.list')}
    <Section title="Avisos e Atividades">
        <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
            {#if activities.length > 0}
                {#each activities as item}  
                    <article class='w-100 h-50 lg:w-[29rem] bg-blue-skywave flex-shrink-0 rounded-lg p-4 relative'>
                        <div class="font-noto-sans font-black italic uppercase text-neutral-aurora text-xl">
                            {item.responsible.nickname}
                        </div>
                        <div class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                            {item.content}
                        </div>
                        {#if item.is_activity}
                            <div class="flex gap-2 absolute bottom-3 left-4">
                                {#if item.confirmations.length > 0}
                                    {#each item.confirmations as confirmation}
                                        <img
                                            src={confirmation.confirmer.avatar}
                                            alt={confirmation.confirmer.nickname}
                                            class="w-9 h-9 rounded-full bg-neutral-aurora"
                                            loading="lazy"
                                        />
                                    {/each}
                                {/if}
                            </div>
                            {#if !item.confirmations.some(c => c.confirmer.id === logged.id)}
                                <button
                                    type="button"
                                    aria-label="Confirmar alerta"
                                    class="w-[2rem] h-[2rem] bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                                    on:click={() => createConfirmation(item.id)}
                                >
                                    <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                                </button>
                            {/if}
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
{/if}