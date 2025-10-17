<script>
    import { scale } from "svelte/transition";
    import { page } from "@inertiajs/svelte";
    import { Navbar } from "@/widgets/admin/navbar";
    import { Status } from "@/widgets/admin/status";
    import Icon from "@iconify/svelte";

    $: ({ flash } = $page.props);
    
    // ------------------------
    // Sistema de Alertas
    // ------------------------
    let alert = null;
    let queue = [];
    let timeout = 5 * 1000;

    $: if (flash) {
        if (flash.message && Array.isArray(flash.message)) {
            queue = [...queue, ...flash.message.map(msg => ({
                type: msg.type,
                message: msg.message || msg,
            }))];
        } else if (flash.type && flash.message) {
            queue = [...queue, {
                type: flash.type,
                message: flash.message
            }];
        }
    }

    async function processQueue(){
        if(queue.length === 0) return;
        alert = queue.shift();
        await new Promise(r=>setTimeout(r, timeout));   // espera o tempo de exibição
        alert = null;
        await new Promise(r=>setTimeout(r, 300)); // espera a animação sumir
        processQueue();
    }

    // Inicia o processamento da fila se houver alertas pendentes
    $: if (queue.length > 0) {
        processQueue();
    }

    function closeAlert(){
        alert = null;
        processQueue();
    }

    function switchColor(type) {
        switch(type) {
            case 'success':
                return '#6aad68'; 
            case 'error':
                return '#962c3f'; 
            case 'warning':
                return '#878717'; 
            case 'info':
                return '#364375'; 
            default:
                return '#515357'; 
        }
    }

    document.body.style.backgroundColor = "var(--color-blue-indigo)";
</script>

{#if alert}
    <div in:scale={{ duration: 300, start: 0.5 }} out:scale={{ duration: 300, end: 0.5 }} class="w-full lg:w-auto lg:max-w-2xl h-17 fixed top-0 lg:top-auto lg:bottom-5 lg:right-5 z-50 rounded-none lg:rounded-lg" style={`background-color: ${switchColor(alert?.type)};`}>
        <button on:click={closeAlert} class="text-neutral-aurora absolute top-1/2 right-5 -translate-y-1/2 cursor-pointer" aria-label="Fechar alerta">
            <Icon icon="mingcute:close-fill" width="15" height="15" aria-hidden="true"/>
        </button>
        <div class="w-auto ml-5 mr-15 h-17 flex items-center font-noto-sans text-neutral-aurora">
            {@html alert?.message}
        </div>
    </div>
{/if}
<header class="mb-15 lg:pt-10">
    <Navbar />
    <slot name="header" />
</header>
<main class="container">
    <slot />
</main>
<footer>
    <div class="h-[5rem]"></div>
    <div class="w-full fixed bottom-0">
        <Status />
    </div>
</footer>
