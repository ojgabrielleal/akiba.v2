<script>
    export let title = null; 
    export let styles = "mb-10"
</script>

<section class={styles}>
    {#if title} 
        <div class="title-section">
            <h1>
                {title}
            </h1>
        </div>
    {/if}
    <slot />
</section>