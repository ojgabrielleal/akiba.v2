<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";

    import { Section } from "@/layouts/admin/";
    import { Task } from "@/components/admin/card";

    import { scrollx } from "@/utils";

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
        {#if tasks.lenght > 0}
            {#each tasks as item}
                <Task due={item.deadline_status === "due_soon"} item={item} action={() => { finishingTask(item.id) }} />
            {/each}
        {:else}
            <Task />
        {/if}
    </div>
</Section>