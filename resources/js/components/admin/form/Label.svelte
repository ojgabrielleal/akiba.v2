<script>
    export let name;
    export let styles = "text-[var(--color-orange-amber)] font-bold italic";
</script>

<label class={`${styles} text-lg uppercase font-noto-sans block mb-1`} for={name}>
    <slot/>
</label>