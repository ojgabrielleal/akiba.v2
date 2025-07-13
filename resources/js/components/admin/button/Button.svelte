<script>
    export let action = null;
    export let styles = "bg-[var(--color-neutral-aurora)] font-noto-sans italic font-bold py-2 px-6 flex justify-center items-center rounded-md cursor-pointer";
    export let type = "button";
</script>   

<button type={type} onclick={action} class={`${styles} flex justify-center items-center cursor-pointer`}>
    <slot />
</button>
