<script>
    export let type = null;

    import { page } from "@inertiajs/svelte";
    import { toast, Toaster } from "svelte-hot-french-toast";

    import NavbarItems from "@/Data/NavbarItems";
    import { NavbarAdmin } from "@/Widgets/Navbar";

    // Flash messages global
    $: flash = $page.props.flash;
    $: if(flash){
        toast[flash.type](flash.message);
    }
</script>

<Toaster position="bottom-end" />
{#if type === "admin"}
    <div class="w-full bg-[var(--color-blue-indigo)]">
        <header class="lg:pt-10">
            <NavbarAdmin items={NavbarItems.admin} />
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
