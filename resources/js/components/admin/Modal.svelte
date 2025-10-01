<script>
    import Icon from "@iconify/svelte";

    let open = false; // controla animação
    let visible = false; // controla se fica no DOM

    function show() {
        visible = true;
        open = true;
    }

    function close() {
        open = false;
        setTimeout(() => {
            visible = false;
        }, 500); 
    }

    // evita que o clique dentro do modal feche
    function block(event) {
        event.stopPropagation();
    }
</script>

<button type="button" onclick={show} class="w-full text-left">
    <slot name="action" />
</button>

{#if visible}
    <!-- svelte-ignore a11y_click_events_have_key_events -->
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <section onclick={close} class={`fixed inset-0 flex items-center justify-center p-9 lg:p-0 z-50 bg-[#00000036] ${open ? "animate-fadeIn" : "animate-fadeOut"}`}>
        <div onclick={block} class="w-full lg:w-[25rem] rounded-t-xl rounded-b-lg bg-neutral-aurora">
            <div class="bg-blue-skywave py-4 px-5 relative rounded-t-lg">
                <slot name="title" />
                <button onclick={close} class="cursor-pointer w-[1.5rem] h-[1.5rem] absolute -top-7 -right-5 flex items-center justify-center bg-neutral-aurora p-1 rounded-full text-[#0000008a]">
                    <Icon icon="mingcute:close-fill" width="20" height="20" />
                </button>
            </div>
            <div class="max-h-[calc(100vh-15rem)] overflow-y-auto p-5">
                <slot name="content" />
            </div>
        </div>
    </section>
{/if}
