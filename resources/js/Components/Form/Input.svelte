<script>
    export let data = {};

    let permantent = { 
        type: "text",
        class: "w-full h-[3.5rem] bg-[var(--color-neutral-aurora)] font-noto-sans rounded-lg outline-none pl-4"
    }

    $: merge = { 
        type: data.type ?? permantent.type,
        name: data.id,
        id: data.id,
        placeholder: data.placeholder,
        class: data.class ?? permantent.class
    }

</script>

<input
    bind:value={merge.value}
    type={merge.type}
    name={merge.id}
    id={merge.id}
    class={merge.styles}
    placeholder={merge.placeholder}
    aria-label={merge.id}
/>
