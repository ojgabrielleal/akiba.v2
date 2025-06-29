<script>
    export let title;

    import { Section } from "@/Layouts";
    import { Task } from "@/Components/Card";

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
        <Task late={true}/>
        <Task/>
        <Task/>
        <Task/>
    </div>
</Section>