<script>
    export let data = {};

    let permantent = {
        bottom: "mb-4"
    }

    $: merge = { 
        title: data.title,
        top: data.top,
        bottom: data.bottom ?? permantent.bottom
    }
</script>

<section class={`${merge.top} ${merge.bottom}`}>
    {#if merge.title} 
        <div class="titleblock">
            <h1>
                {merge.title}
            </h1>
        </div>
    {/if}
    <slot />
</section>