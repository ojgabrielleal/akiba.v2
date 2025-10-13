<script>
    import { fly, fade } from 'svelte/transition';
    import { quintOut } from 'svelte/easing';
    import Icon from "@iconify/svelte";
    
    let visible = false;

    export function show() {
        visible = true;
    }

    export function close() {
        visible = false;
    }

    function block(event) {
        event.stopPropagation();
    }
</script>

<button type="button" on:click={show} aria-label="Abrir offcanvas">
    <slot name="action" />
</button>

{#if visible}
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <section on:click={close} transition:fade={{ x: '100%', duration: 500, easing: quintOut }} class="fixed inset-0 flex justify-end z-50 bg-[#00000086]">
        <div on:click={block} transition:fly={{ x: '100%', duration: 500, easing: quintOut }} class="w-full h-full lg:w-[25rem] bg-neutral-aurora flex flex-col">
            <div class="bg-blue-skywave py-5 px-5 relative flex justify-between items-center">
                <div class="text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    <slot name="title" />
                </div>
                <button type="button" on:click={close} class="cursor-pointer text-neutral-aurora" aria-label="Fechar offcanvas">
                    <Icon icon="mingcute:close-fill" width="24" height="24" aria-hidden="true" />
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 bg-neutral-aurora">
                <slot name="content" {close} />
            </div>
        </div>
    </section>
{/if}
