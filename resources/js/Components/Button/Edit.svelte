<script>
    export let action;
    export let styles;
    export let type = "button";
</script>

{#if action}
    <button type={type} onclick={action} class={`${styles} w-[2rem] h-[2rem] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/edit.svg" alt="edit icon" class="w-5 color-filter-aurora"/>
    </button>
{:else}
    <button type={type} class={`${styles} w-[2rem] h-[2rem] flex justify-center items-center rounded-md cursor-pointer`}>
        <img src="/icons/edit.svg" alt="edit icon" class="w-5 color-filter-aurora"/>
    </button>
{/if}