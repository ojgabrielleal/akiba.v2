<script>
    export let type;

    import { page } from "@inertiajs/svelte"
    import { toast, Toaster } from "svelte-hot-french-toast";
    
    import Navbar from "@/Data/Navbar";
    import { Admin } from "@/Widgets/Navbar";

    $: ({ flash } = $page.props);

    $: if (flash) {
        toast[flash.type](flash.message);
    }
</script>

<Toaster position="bottom-end"/>
{#if type === "admin"}
    <div class="w-screen bg-[var(--color-blue-indigo)]">
        <header class="lg:pt-10">
            <Admin items={Navbar.admin} />
            <slot name="header" />
        </header>

        <main class="container">
            <slot />
        </main>
    </div>
{:else if type === "user"}
    <div>
        <slot />
    </div>
{:else}
    <slot />
{/if}
