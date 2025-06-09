<script>
    import { Toaster } from "svelte-hot-french-toast";
    
    import NavbarItems from "@/Data/NavbarItems";
    import { NavAdmin } from "@/Widgets/Navbar";
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
