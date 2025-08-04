<script>
    export let name = null;
    export let width = "w-full";
    export let height = "h-[15rem] lg:h-[23rem]";
    export let previewHeight = "h-full";

    let preview = null;

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            preview = null;
        }
    }
</script>

<label class="cursor-pointer">
    {#if preview}
        <img src={preview} alt="Preview" class={`w-full ${previewHeight} rounded-lg object-cover object-top`} />
    {:else}
        <div class={`${width} ${height} bg-[var(--color-neutral-aurora)] rounded-lg flex items-center justify-center overflow-hidden font-noto-sans text-[var(--color-blue-skywave)] text-7xl font-bold italic uppercase`}>
            +
        </div>
    {/if}
    <input name={name} id={name} type="file" class="hidden" accept="image/*" on:change={previewImage} />
</label>
