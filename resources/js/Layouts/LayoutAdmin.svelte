<script>
    import { page } from "@inertiajs/svelte"
    import { toast, Toaster } from "svelte-hot-french-toast";
    
    import NavbarItems from "@/Data/NavbarItems";
    import { NavAdmin } from "@/Widgets/Navbar";

    let { flash } = $page.props;

    $: if (flash) {
        if (flash.type === "success") toast.success(flash.message);
        if (flash.type === "error") toast.error(flash.message);
        if (flash.type === "warning") toast.warning(flash.message);
        if (flash.type === "info") toast.info(flash.message);
    }
</script>

<Toaster />
<div class="w-screen bg-[var(--color-blue-indigo)]">
    <header class="lg:pt-10">
        <NavAdmin items={NavbarItems.admin} />
        <slot name="header" />
    </header>

    <main class="container">
        <slot />
    </main>
</div>
