<script>
    import { page } from "@inertiajs/svelte";
    import { toast, Toaster } from "svelte-hot-french-toast";

    import { Navbar } from "@/widgets/admin/navbar";
    import { Analytics } from "@/widgets/admin/analytics";

    import NavbarItems from "@/data/admin/Navbar";

    $: ({ user, flash } = $page.props);

    $: if(flash && flash.type && flash.message){
        toast[flash.type](flash.message);
    }

    // Define background color used in the layout
    document.body.style.backgroundColor = "var(--color-blue-indigo)";
</script>

<Toaster position="bottom-end" />
<header class="mb-15 lg:pt-10">
    <Navbar items={NavbarItems} user={user}/>
    <slot name="header" />
</header>
<main class="container">
    <slot />
</main>
<footer>
    <div class="h-[5rem]"></div>
    <div class="w-full fixed bottom-0">
        <Analytics/>
    </div>
</footer>
