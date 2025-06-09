<script>
    import toast from "svelte-hot-french-toast"

    import { LayoutSection } from "@/Layouts";
    import { Card } from "@/Components/Card";

    // Scroll X to cards
    let container;
    function scrollx(event) {
        if (event.shiftKey) {
            event.preventDefault();
            container.scrollLeft += event.deltaY;
        }
    }

    function notify(){
        if(window.innerWidth > 900) { 
            toast.info("Pressione SHIFT + Scroll para rolar", {
                duration: 1000,
            })
        }
    }
</script>

<LayoutSection title="Avisos para a equipe" styles="mt-8 lg:mt-20 mb-4">
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={scrollx} on:mouseenter={notify} role="group">
        <Card type="alert"/>
        <Card type="alert" />
        <Card type="alert" />
        <Card type="alert" />
        <Card type="alert" />
        <Card type="alert" />
        <Card type="alert" />
    </div>
</LayoutSection>
