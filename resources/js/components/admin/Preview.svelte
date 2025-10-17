<script>
    export let name = null;
    export let size = "w-full h-[15rem] lg:h-[23rem]";
    export let view = "w-full max-h-[15rem] lg:max-h-[23rem]";
    export let src = null;
    export let oninput = null;

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
        <img src={imageToShow} alt="" aria-hidden="true" class={`${view} rounded-lg object-contain object-top`} loading="lazy"/>
    {:else}
        <div class={`${size} bg-neutral-aurora rounded-lg flex items-center justify-center overflow-hidden font-noto-sans text-blue-skywave text-7xl font-bold italic uppercase`}>
            +
        </div>
    {/if}
    <input
        id={name}
        type="file"
        name={name}
        class="hidden"
        accept="image/*"
        on:input={oninput}
        on:change={previewImage}
    />
</label>
