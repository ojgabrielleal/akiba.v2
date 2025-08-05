<script>
    export let title = null;
    
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Alert } from "@/components/admin/card";

    import { scrollx } from "@/utils";

    $:({ alerts } = $page.props); 

    // Reference to component
    let container;

    // Submit user to signature card 
    function createSignature(id) {
        router.post(`/painel/alerts/signature/${id}`);
    }
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={(e)=> scrollx(e, container)} role="group">      
        {#if alerts.length > 0}
            {#each alerts as item}
                <Alert item={item} action={() => createSignature(item.id)} />
            {/each}
        {:else}
            <Alert />
        {/if}
    </div>
</Section>
