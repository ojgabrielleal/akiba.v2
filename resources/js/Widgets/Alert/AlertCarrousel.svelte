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

    //Props to components
    let layoutSection = {
        title: "Avisos para a equipe", 
        top: "mt-8 lg:mt-20"
    }
</script>

<LayoutSection data={layoutSection}>
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
