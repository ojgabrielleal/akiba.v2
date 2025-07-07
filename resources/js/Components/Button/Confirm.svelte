<script>
    export let action;
    export let styles;
    export let type = "button";
</script>

{#if action}
    <button type={type} onclick={action} class={`${styles} w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
    </button>
{:else}
    <button type={type} class={`${styles} w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
    </button>
{/if}
