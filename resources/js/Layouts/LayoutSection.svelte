<script>
    export let title;
    export let styles;
    export let top;
    export let bottom;

    $: styles = styles ? styles : ""
    $: top = top ? top : ""
    $: bottom = bottom ? bottom : "mb-4";
</script>

<section class={`${styles} ${top} ${bottom}`}>
    {#if title} 
        <div class="titleblock">
            <h1>
                {title}
            </h1>
        </div>
    {/if}
    <slot />
</section>