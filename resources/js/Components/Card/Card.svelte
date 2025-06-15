<script>
    export let type;
    export let colors = "bg-[var(--color-blue-skywave)]";
    export let action;
    export let data = {};
    
    import { page } from "@inertiajs/svelte";

    let { user } = $page.props;

</script>

{#if type === "alert"}
    <div class={`w-[29rem] h-[13rem] flex-shrink-0 rounded-sm p-4 relative ${colors}`}>
        <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl">
            {data?.author?.nickname}
        </h1>
        <p class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {data?.content} 
        </p>
        <div class="flex gap-2 absolute bottom-3 left-4">
            {#if data?.signatures?.length > 0}
                {#each data?.signatures?.slice(0, 5) as signature}
                    <img src={signature?.user?.avatar} alt={signature?.user?.nickname} class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
                {/each}
            {/if}
        </div>
        {#if !data?.signatures?.some(signature => signature.user.id === user.id)}
            <button on:click={action} class="w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md absolute bottom-3 right-4">
                <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
            </button>
        {/if}
    </div>
{/if}