<script>
    export let title;
    
    import { page } from "@inertiajs/svelte";

    import { router } from "@inertiajs/svelte";
    import { Section } from "@/Layouts";
    import { Alert } from "@/Components/Card";

    $:({ user, alerts } = $page.props); 

    // Submit user to signature card 
    function createSignature(alertIdentifier) {
        router.post("/painel/alerts/signature/" + alertIdentifier);
    }

    // Scroll X to cards
    let container;
    function scrollx(event) {
        if (container && container.scrollWidth > container.clientWidth) {
            container.scrollLeft += event.deltaY;
            event.preventDefault();
        }
    }
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={scrollx} role="group">
        {#if alerts.every(item => item.signatures.some(signature => signature.user.id === user.id))}
            <Alert desactivate={true}/>
        {:else}
            {#each alerts as item}
                {#if !item.signatures.some(signature => signature.user.id === user.id)}
                    <Alert data={item} action={() => createSignature(item.id)}/>
                {/if}
            {/each}
        {/if}
    </div>
</Section>
