<script>
    import { fly } from "svelte/transition";
    import { onMount } from "svelte";

    let deferredPrompt = null;
    let showBanner = false;

    onMount(() => {
        const isMobile = /Mobi/i.test(window.navigator.userAgent);
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
        const installDeclined = !!localStorage.getItem("pwaInstallDeclined");

        if (isMobile && !isStandalone && !installDeclined) {
            window.addEventListener("beforeinstallprompt", (e) => {
                e.preventDefault();
                deferredPrompt = e;
                showBanner = true;
            });
        }
    });

    async function installApp() {
        if (!deferredPrompt) return;

        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;

        if (outcome === "accepted") {
            showBanner = false;
        }

        deferredPrompt = null;
    }

</script>

{#if showBanner}
    <div transition:fly={{ y: 40, duration: 400, opacity: 0.2 }} class="w-[90vw] fixed top-10 left-1/2 transform -translate-x-1/2 bg-blue-skywave text-neutral-aurora px-5 py-4 rounded-2xl shadow-2xl flex flex-col gap-1 items-center z-[1000]">
        <button class="flex gap-3" on:click={installApp}>
            <div class="w-11 h-11 flex-shrink-0">
                <img src="/img/pwa/192.png" alt="" aria-hidden="true" class="rounded-full shadow-md"/>
            </div>
            <div class="flex flex-col h-11 justify-center">
                <div class="text-sm text-start font-noto-sans font-semibold drop-shadow-sm">
                    Instalar aplicativo
                </div>
                <div class="text-sm text-start font-noto-sans font-light drop-shadow-sm">
                    Toque para instalar e leve a Akiba com você na palma da sua mão!
                </div>
            </div>
        </button>

    </div>
{/if}
