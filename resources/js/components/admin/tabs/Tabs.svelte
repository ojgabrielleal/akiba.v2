<script>
    export let items = null;

    import { Link } from "@inertiajs/svelte";
    import { Button } from "@/components/admin/button";
</script>

<div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
    {#each items as item}
        {#if item.redirect}
            <Link href={item.redirect} aria-label={item.label}>
                <Button styles={`${item.styles ?? ""} w-full lg:w-auto py-2 px-6`} action={item.action ?? null}>
                    {item.label}
                </Button>
            </Link>
        {:else if item.action}
            <Button styles={`${item.styles ?? ""} w-full lg:w-auto py-2 px-6`} action={item.action}>
                {item.label}
            </Button>
        {:else}
            <Button styles={`${item.styles ?? ""} w-full lg:w-auto py-2 px-6`}>
                {item.label}
            </Button>
        {/if}
    {/each}
</div>
