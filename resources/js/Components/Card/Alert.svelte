<script>
    export let colors = "bg-[var(--color-blue-skywave)]";
    export let action;
    export let data = {};
    
    import { page } from "@inertiajs/svelte";
    import { Confirm } from "@/Components/Button"

    let { user } = $page.props;

</script>

<div class={`${colors} w-[29rem] h-50 flex-shrink-0 rounded-lg p-4 relative`}>
    <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl">
        {data.author.nickname}
    </h1>
    <p class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
        {data.content} 
    </p>
    <div class="flex gap-2 absolute bottom-3 left-4">
        {#if data.signatures.length > 0}
            {#each data.signatures.slice(0, 4) as signature}
                <img src={signature.user.avatar} alt={signature.user.nickname} class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
            {/each}
        {/if}
    </div>
    {#if !data.signatures.some(signature => signature.user.id === user.id)}
        <Confirm action={action} styles="absolute bottom-3 right-4"/>    
    {/if}
</div>
