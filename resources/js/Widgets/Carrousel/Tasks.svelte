<script>
    export let title;

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/Layouts";
    import { Task } from "@/Components/Card";

    $:({ tasks } = $page.props); 

    // Scroll X to cards
    let container;
    function scrollx(event) {
        if (container && container.scrollWidth > container.clientWidth) {
            container.scrollLeft += event.deltaY;
            event.preventDefault();
        }
    }

    // Finishing task 
    function finishingTask(taskIdentifier) {
        router.patch("/painel/tasks/completed/" + taskIdentifier);
    }

</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={scrollx} role="group">
        {#if tasks.every(item => item.completed === true)}
            <Task desactivate={true} />
        {:else}
            {#each tasks as item}
                {#if item.deadline_status === "due_soon"}
                    <Task due={true} data={item} action={() => { finishingTask(item.id) }} />
                {:else}
                    <Task data={item} action={() => { finishingTask(item.id) }} />
                {/if}
            {/each}
        {/if}
    </div>
</Section>