<script>
    export let type = "text";
    export let id;
    export let value;
    export let className = "w-full h-[3.5rem] bg-[var(--color-neutral-aurora)] font-noto-sans rounded-lg outline-none pl-4";
    export let placeholder;
    export let ariaLabel = "input";

</script>

<input
    bind:value
    type={type}
    name={id}
    id={id}
    class={className}
    placeholder={placeholder}
    aria-label={ariaLabel}
/>
