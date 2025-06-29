<script>
    export let action;
    export let styles;
</script>

{#if action}
    <button onclick={action} class={`${styles} w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
    </button>
{:else}
    <button class={`${styles} w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
    </button>
{/if}
