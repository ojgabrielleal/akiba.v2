<script>
    export let action;
    export let styles;
    export let type = "button";
</script>

{#if action}
    <button type={type} onclick={action} class={`${styles} bg-[var(--color-red-crimson)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold py-2 px-6 rounded-full uppercase cursor-pointer`}>
        <slot/>
    </button>
{:else}
    <button type={type} class={`${styles} bg-[var(--color-red-crimson)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold py-2 px-6 rounded-full uppercase`}>
        <slot/>
    </button>
{/if}