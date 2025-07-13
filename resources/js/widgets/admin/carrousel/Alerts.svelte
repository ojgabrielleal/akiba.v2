<script>
    export let title = null;
    export let global = false;
    
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Alert } from "@/components/admin/card";

    import { scrollx } from "@/utils";

    $:({ user, alerts } = $page.props); 

    // Reference to component
    let container;

    // Submit user to signature card 
    function createSignature(id) {
        router.post(`/painel/alerts/signature/${id}`);
    }
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={(e)=> scrollx(e, container)} role="group">
        {#if alerts.every(item => item.signatures.some(signature => signature.user.id === user.id))}
            <Alert/>
        {:else}
            {#each alerts as item}
                {#if global}
                    <Alert item={item} action={() => createSignature(item.id)}/>
                {:else}
                    {#if !item.signatures.some(signature => signature.user.id === user.id)}
                        <Alert item={item} action={() => createSignature(item.id)}/>
                    {/if}
                {/if}
            {/each}
        {/if}
    </div>
</Section>
