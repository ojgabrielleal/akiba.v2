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

    // evita que o clique dentro do modal feche
    function block(event) {
        event.stopPropagation();
    }
</script>

<button type="button" on:click={show} class="w-full text-left">
    <slot name="action" />
</button>

{#if visible}
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <section on:click={close} class="fixed inset-0 flex justify-end z-50 bg-[#00000036]">
        <div on:click={block} transition:fly={{ x: '100%', duration: 500, easing: quintOut }} class="w-full h-full lg:w-[25rem] bg-neutral-aurora flex flex-col">
            <div class="bg-blue-skywave py-5 px-5 relative flex justify-between items-center">
                <div class="text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    <slot name="title" />
                </div>
                <button on:click={close} class="cursor-pointer text-neutral-aurora">
                    <Icon icon="mingcute:close-fill" width="24" height="24" />
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 bg-neutral-aurora">
                <slot name="content" {close} />
            </div>
        </div>
    </section>
{/if}
