<script>
    export let name;
</script>

<label class="text-[var(--color-orange-amber)] text-lg uppercase italic font-bold font-noto-sans block mb-2" for={name}>
    <slot/>
</label>