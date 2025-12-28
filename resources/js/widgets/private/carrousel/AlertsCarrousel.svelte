<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/private/";
    import { scrollx } from "@/utils";

    $: ({ alerts } = $page.props);

    let container;

    function createSignature(id) {
        router.post(`/painel/dashboard/create/alert/signature/${id}`);
    }
</script>

<Section title="Avisos para a equipe">
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={(e) => scrollx(e, container)} role="group">
        {#if alerts?.length > 0}
            {#each alerts as item}
                <article class="w-100 h-50 lg:w-[29rem] bg-blue-skywave flex-shrink-0 rounded-lg p-4 relative">
                    <div class="font-noto-sans font-black italic uppercase text-neutral-aurora text-xl">
                        {item.user.nickname}
                    </div>
                    <div class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                        {item.content}
                    </div>
                    <div class="flex gap-2 absolute bottom-3 left-4">
                        {#if item.signatures.length > 0}
                            {#each item.signatures as signature}
                                <img
                                    src={signature.user.avatar}
                                    alt={signature.user.nickname}
                                    class="w-9 h-9 rounded-full bg-neutral-aurora"
                                    loading="lazy"
                                />
                            {/each}
                        {/if}
                    </div>
                    {#if item.actions.confirm}
                        <button
                            type="button"
                            aria-label="Confirmar alerta"
                            class="w-[2rem] h-[2rem] bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                            on:click={() => createSignature(item.id)}
                        >
                            <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                        </button>
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
