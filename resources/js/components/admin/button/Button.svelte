<script>
    export let action = null;
    export let styles = "bg-[var(--color-neutral-aurora)] py-2 px-6 rounded-md";
    export let type = "button";
    export let name = null;
    export let value = null;
    
</script>   

<button type={type} onclick={action} name={name} value={value} class={`${styles} flex justify-center items-center font-noto-sans italic font-bold cursor-pointer`}>
    <slot />
</button>
