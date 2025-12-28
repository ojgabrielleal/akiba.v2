<script>
    export let name = null;
    export let standard = "w-full h-[15rem] lg:h-[23rem] rounded-lg";
    export let view = "w-full max-h-[15rem] lg:max-h-[23rem] object-contain object-top rounded-lg bg-neutral-aurora";
    export let src = null;
    export let oninput = null;
    export let required = false;

    let preview = null;

    $: imageToShow = preview ?? (src && src !== "#" ? src : null);

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
    {#if imageToShow}
        <img src={imageToShow} alt="" aria-hidden="true" class={`${view}`} loading="lazy"/>
    {:else}
        <div class={`${standard} bg-neutral-aurora flex items-center justify-center overflow-hidden font-noto-sans text-blue-skywave text-7xl font-bold italic uppercase`}>
            +
        </div>
    {/if}
    <input
        id={name}
        type="file"
        name={name}
        class="sr-only"
        accept="image/*"
        on:input={oninput}
        on:change={previewImage}
        required={required}
    />
</label>
