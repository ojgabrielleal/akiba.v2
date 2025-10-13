<script>
    import { page } from "@inertiajs/svelte";
    import { Navbar } from "@/widgets/admin/navbar";
    import { Status } from "@/widgets/admin/status";
    import Icon from "@iconify/svelte";

    $: ({ flash } = $page.props);

    let alertMessage = null;
    let alertColor = null;
    let alertIcon = null;

    $: if (flash && flash.type && flash.message) {
        alertMessage = flash.message;
        switch (flash.type) {
            case "success":
                alertColor = "#059669"; 
                alertIcon = "bi:hand-thumbs-up-fill";
                break;
            case "info":
                alertColor = "#1D4ED8"; 
                alertIcon = "bi:patch-exclamation-fill";
                break;
            case "warning":
                alertColor = "#B91C1C"; 
                alertIcon = "mingcute:close-fill";
                break;
            default:
                alertColor = "#6B7280"; 
                alertIcon = "bi:chat-left-dots-fill";
                break;
        }

        setTimeout(() => {
            alertMessage = null;
            alertColor = null;
        }, 10 * 1000);
    }

    document.body.style.backgroundColor = "var(--color-blue-indigo)";
</script>

<header class="mb-15 lg:pt-10">
    <Navbar />
    <slot name="header" />
</header>
<main class="container">
    {#if alertMessage && alertColor}
        {#if Array.isArray(alertMessage)}
            {#each alertMessage as message}
                <div class="mb-15 p-4 flex items-center gap-2 rounded-lg font-noto-sans font-light text-neutral-aurora transition-opacity duration-500 ease-in-out" style={`background-color: ${alertColor}`}>
                    <Icon icon={alertIcon} width="16" height="16"/>
                    {@html message}
                </div>
            {/each}
        {:else}
            <div class="mb-15 p-4 flex items-center gap-2 rounded-lg font-noto-sans font-light text-neutral-aurora transition-opacity duration-500 ease-in-out opacity-100" style={`background-color: ${alertColor}`}>
                <Icon icon={alertIcon} width="16" height="16"/>
                {@html alertMessage}
            </div>
        {/if}
    {/if}

    <slot />
</main>
<footer>
    <div class="h-[5rem]"></div>
    <div class="w-full fixed bottom-0">
        <Status />
    </div>
</footer>
