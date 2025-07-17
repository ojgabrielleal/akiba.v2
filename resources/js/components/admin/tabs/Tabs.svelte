<script>
    export let items = null;

    import { Link } from "@inertiajs/svelte";
    import { Button } from "@/components/admin/button";

</script>

<div class="flex gap-4 justify-center">
    {#each items as item}
        {#if item.redirect}
            <Link href={item.redirect} aria-label={item.label}>
                <Button styles={item.styles + " py-2 px-6" ?? null} action={item.action ?? null}>
                    {item.label}
                </Button>
            </Link>
        {:else}
            <Button styles={item.styles + " py-2 px-6" ?? null}>
                {item.label}
            </Button>
        {/if}
    {/each}
</div>