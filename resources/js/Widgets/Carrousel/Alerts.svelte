<script>
    export let title;
    export let data = {};

    import { router } from "@inertiajs/svelte";
    import { Section } from "@/Layouts";
    import { Alert } from "@/Components/Card";

    // Submit user to signature card 
    function createSignature(alertIdentifier) {
        router.post("/action/alerts/signature/" + alertIdentifier);
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

{#if data.length > 0}
    <Section title={title}>
        <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={scrollx} role="group">
            {#each data as item}
                <Alert type="alert" colors="bg-[var(--color-blue-skywave)]" data={item} action={() => { createSignature(item.id) }}/>
            {/each}
        </div>
    </Section>
{/if}