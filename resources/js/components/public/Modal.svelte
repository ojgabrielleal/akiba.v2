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

<button type="button" on:click={show} aria-label="Abrir modal">
    <slot name="action" />
</button>

{#if visible}
<!-- svelte-ignore a11y_click_events_have_key_events -->
<!-- svelte-ignore a11y_no_static_element_interactions -->
<div on:click={close} transition:fade={{ x: '100%', duration: 500, easing: quintOut }} class="w-screen h-screen fixed inset-0 flex justify-center items-center p-9 bg-[#00000086] z-[50]">
    <div on:click={block} class="lg:w-[26rem] bg-neutral-aurora rounded-t-lg rounded-b-md relative">        
        <div class="w-full h-[5rem] pt-8 px-5 lg:mb-2 bg-cover bg-center rounded-t-md" style="background-image: url('/img/default/requests.webp');">
            <div class="w-[9rem]">
                <img src="/img/default/logo.webp" alt="logo">
            </div>
            <button type="button" aria-label="Fechar modal" on:click={close} class="w-[1.5rem] h-[1.5rem] cursor-pointer absolute -top-8 -right-5 flex justify-center items-center bg-neutral-aurora rounded-full text-black" >
                <Icon icon="mingcute:close-fill" width="10" height="10" aria-hidden="true" />
            </button>
        </div>
        <div class="w-full max-h-[70vh] lg:max-h-[80vh] p-5 overflow-y-auto">
             <slot name="content" {close} />
        </div>
    </div>
</div>
{/if}
