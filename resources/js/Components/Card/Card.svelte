<script>
    export let type;
    export let colors;
    export let actions;
    export let data;

    $: type = type ? type : undefined;
    $: colors = colors ? colors : "bg-[var(--color-blue-skywave)]";
    $: actions = actions ? actions : {};
    $: data = data ? data : {};
</script>

{#if type === "alert"}
    <div class={`w-[29rem] h-[13rem] flex-shrink-0 rounded-sm p-4 relative ${colors}`}>
        <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl">
            Takashi
        </h1>
        <p class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus placerat neque et pharetra commodo. Donec sit amet nulla iaculis, finibus odio id, pharetra justo. Nam leo metus, cursus eget tortor quis, accumsan mollis risus. Nulla varius risus vel lorem consectetur ultrices. Nunc consectetur eleifend erat ac fringilla. Sed mollis magna et luctus egestas. Nunc ex ligula, convallis ut tortor vitae, suscipit cursus odio.
        </p>
        <div class="flex gap-2 absolute bottom-3 left-4">
            <img src="https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png" alt="profile avatar" class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
            <img src="https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png" alt="profile avatar" class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
            <img src="https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png" alt="profile avatar" class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
            <img src="https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png" alt="profile avatar" class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
            <img src="https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png" alt="profile avatar" class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
        </div>
        <button class="w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] flex justify-center items-center rounded-md absolute bottom-3 right-4">
            <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
        </button>
    </div>
{/if}