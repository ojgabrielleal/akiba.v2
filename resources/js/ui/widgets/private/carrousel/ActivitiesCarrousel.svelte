<script>
    export let title; 

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx } from "@/utils";

    $: ({ activities } = $page.props);

    $: console.log(activities);

    const confirmActivityParticipant = (activity) => {
        router.post(`/painel/dashboard/activity/${activity}/confirm`);
    }

</script>

{#if activities}
    <Section {title}>
        <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
            {#if activities.data.length > 0}
                {#each activities.data as item}  
                    <article class='{item.ui.background} w-100 h-50 lg:w-[29rem] flex-shrink-0 rounded-lg p-4 relative'>
                        <div class='{item.ui.texts} font-noto-sans font-black italic uppercase text-xl'>
                            {item.author.nickname}
                        </div>
                        <div class='{item.ui.texts} font-noto-sans text-sm line-clamp-5 mt-1'>
                            {item.content}
                        </div>
                        {#if item.allows_confirmations}
                            <div class="flex gap-2 absolute bottom-3 left-4">
                                {#each item.confirmations as confirmation}
                                    <img
                                        src={confirmation.confirmer.avatar}
                                        alt={confirmation.confirmer.nickname}
                                        class="w-10 h-10 rounded-full bg-neutral-aurora object-cover object-top"
                                        loading="lazy"
                                    />
                                {/each}
                            </div>
                            {#if item.actions.participate}
                                <button
                                    type="button"
                                    aria-label="Confirmar alerta"
                                    class="w-[2rem] h-[2rem] bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer disabled:opacity-50"
                                    on:click={() => confirmActivityParticipant(item.uuid)}
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
