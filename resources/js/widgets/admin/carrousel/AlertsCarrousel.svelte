<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { scrollx } from "@/utils";

    $: ({ alerts } = $page.props);

    // Reference to component
    let container;

    // Submit user to signature card
    function createSignature(id) {
        router.post(`/painel/dashboard/alerts/${id}`);
    }
</script>

<Section {title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} onwheel={(e) => scrollx(e, container)} role="group">
        {#if alerts?.length > 0}
            {#each alerts as item}
                <div class="w-100 h-50 lg:w-[29rem] bg-blue-skywave flex-shrink-0 rounded-lg p-4 relative">
                    <h1 class="font-noto-sans font-black italic uppercase text-neutral-aurora text-xl">
                        {item.user.nickname}
                    </h1>
                    <span class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                        {item.content}
                    </span>
                    <div class="flex gap-2 absolute bottom-3 left-4">
                        {#if item.signatures.length > 0}
                            {#each item.signatures as signature}
                                <img src={signature.user.avatar} alt={signature.user.nickname} class="w-9 h-9 rounded-full bg-neutral-aurora"/>
                            {/each}
                        {/if}
                    </div>
                    {#if item.actions.confirm}
                        <button class="w-[2rem] h-[2rem] bg-neutral-aurora absolute bottom-3 right-4 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer" onclick={() => createSignature(item.id)}>
                            <img src="/icons/default/verify.svg" alt="verify icon" class="w-5"/>
                        </button>
                    {/if}
                </div>
            {/each}
        {:else}
            <div class="w-100 h-50 lg:w-[29rem] bg-blue-cerulean opacity-50 flex-shrink-0 rounded-lg p-4 relative">
                <h1 class="font-noto-sans font-black italic uppercase text-neutral-aurora text-xl">
                    Aki-chan
                </h1>
                <span class="font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                    Não se preocupe se você não foi lembrado meu bem. Vou estar aqui ao seu lado, só nós dois esse tempo!
                    Quando quiserem algo certeza que vão avisar a gente!
                </span>
            </div>
        {/if}
    </div>
</Section>
