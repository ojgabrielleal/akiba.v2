<script>
    import { page } from "@inertiajs/svelte";
    import { toast, Toaster } from "svelte-hot-french-toast";

    import { Navbar } from "@/Widgets/Admin/Navbar";
    import NavbarItems from "@/Data/Admin/Navbar";

    $: ({ user } = $page.props);

    // Flash messages global
    $: flash = $page.props.flash;
    $: if(flash){
        toast[flash.type](flash.message);
    }
</script>

<Toaster position="bottom-end" />
<div class="w-full bg-[var(--color-blue-indigo)]">
    <header class="lg:pt-10">
        <Navbar items={NavbarItems} user={user}/>
        <slot name="header" />
    </header>
    <main class="container">
        <slot />
    </main>
</div>

