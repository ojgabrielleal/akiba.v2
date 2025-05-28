<script>
    export let type = "text";
    export let id;
    export let value;
    export let styles =
        "w-full h-[3.5rem] bg-[var(--color-neutral-aurora)] font-noto-sans rounded-lg outline-none pl-4";
    export let placeholder;
    export let ariaLabel = "input";
</script>

<input
    bind:value
    {type}
    name={id}
    {id}
    class={styles}
    {placeholder}
    aria-label={ariaLabel}
/>
