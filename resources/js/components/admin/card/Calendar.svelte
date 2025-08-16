<script>
    export let item = null;
</script>

{#if item}
    <div class="w-full rounded-lg pt-4 pl-4 pr-4 pb-3 mb-5 2xl:w-[12.7rem]" style="background-color: {item.styles.bg}">
        <span class="w-full font-noto-sans text-2xl text-center text-neutral-aurora uppercase block">
            {item.hour}H
        </span>
        <h1 class="w-full font-noto-sans font-bold text-2xl text-center text-neutral-aurora italic mt-3 mb-3">
            {item.content}
        </h1>
        <span class="w-full font-noto-sans text-md text-end text-neutral-aurora block">
            {item.user.nickname}
        </span>
    </div>
{:else}
    <div class="w-[12.7rem] rounded-lg pt-4 pl-4 pr-4 pb-3">
    </div>
{/if}
