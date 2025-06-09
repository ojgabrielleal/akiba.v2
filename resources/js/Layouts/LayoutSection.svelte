<script>
    export let title; 
    export let styles = "mb-4"

</script>

<section class={styles}>
    {#if title} 
        <div class="title-session">
            <h1>
                {title}
            </h1>
        </div>
    {/if}
    <slot />
</section>