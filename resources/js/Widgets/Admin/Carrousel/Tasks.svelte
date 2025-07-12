<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/Layouts/Admin/";
    import { Task } from "@/Components/Admin/Card";

    import { scrollx } from "@/Utils";

    $:({ tasks } = $page.props); 

    // Reference to component
    let container;

    // Submit user to finishing task
    function finishingTask(id) {
        router.patch(`/painel/tasks/completed/${id}`);
    }
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={(e) => scrollx(e, container)} role="group">
        {#if tasks.every(item => item.completed === true)}
            <Task />
        {:else}
            {#each tasks as item}
                <Task due={item.deadline_status === "due_soon"} item={item} action={() => { finishingTask(item.id) }} />
            {/each}
        {/if}
    </div>
</Section>