<script>
    import { page, router } from "@inertiajs/svelte";

    import { Section } from "@/Layouts";
    import { Card } from "@/Components/Card";

    $: ({ alerts } = $page.props);

    // Submit user to signature card 
    function createSignature(alertIdentifier) {
        router.post("/painel/dashboard/alerts/signature/" + alertIdentifier);
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

{#if alerts.length > 0}
    <Section title="Avisos para a equipe">
        <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={scrollx} role="group">
            {#each alerts as item}
                <Card type="alert" colors="bg-[var(--color-blue-skywave)]" data={item} action={() => { createSignature(item.id) }}/>
            {/each}
        </div>
    </Section>
{/if}