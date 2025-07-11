<script>
    export let item = null;
    export let category = null;

    const colorMap = {
        live: 'var(--color-purple-mystic)',
        video: 'var(--color-red-crimson)',
        podcast: 'var(--color-green-forest)',
        show: 'var(--color-blue-skywave)',
    };

    $: color = colorMap[category]
</script>

{#if item}
    <div class="w-full rounded-lg pt-4 pl-4 pr-4 pb-3 mb-5 2xl:w-[12.7rem]" style="background-color: {color}">
        <span class="w-full font-noto-sans text-2xl text-center text-[var(--color-neutral-aurora)] uppercase block">
            {item.hour}H
        </span>
        <h1 class="w-full font-noto-sans font-bold text-2xl text-center text-[var(--color-neutral-aurora)] italic mt-3 mb-3">
            {item.content}
        </h1>
        <span class="w-full font-noto-sans text-md text-end text-[var(--color-neutral-aurora)] block">
            {item.user.nickname}
        </span>
    </div>
{:else}
    <div class="w-[12.7rem] rounded-lg pt-4 pl-4 pr-4 pb-3">
    </div>
{/if}
