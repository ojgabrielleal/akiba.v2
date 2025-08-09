<script>
    export let options = [];
    export let name = "";
    export let selected = null;

    $: if (selected === null || selected === undefined) {
        selected = "#";
    }
</script>

<div class="relative w-full">
    <select
        bind:value={selected}
        name={name}
        class="w-full h-[3rem] bg-[var(--color-neutral-aurora)] font-noto-sans rounded-lg outline-none pl-4 pr-10 appearance-none"
    >
        {#each options as option}
            <option value={option.value}>{option.label}</option>
        {/each}
    </select>

    <svg
        class="w-[1.5rem] h-[1.5rem] absolute right-4 top-2/4 transform -translate-y-1/2 pointer-events-none text-[var(--color-blue-skywave)]"
        fill="currentColor"
        viewBox="0 0 20 20"
    >
        <path
            fill-rule="evenodd"
            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.937a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
            clip-rule="evenodd"
        />
    </svg>
</div>
