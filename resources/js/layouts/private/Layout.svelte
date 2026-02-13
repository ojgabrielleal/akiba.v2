<script>
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import toast, { Toaster } from "svelte-hot-french-toast"
    import { Navbar } from "@/ui/widgets/private/navbar";
    import { RadioMetrics } from "@/ui/widgets/private/metrics";

    $: ({ 
        flash,
        user 
    } = $page.props);

    if(flash){
        toast(flash.message, {
            icon: flash.icon
        });
    }
    
    onMount(()=>{
        document.body.style.backgroundColor = "var(--color-blue-indigo)";
    });
</script>


<Toaster/>
<header class="mb-15 lg:pt-10">
    <Navbar {user} />
</header>
<main class="container">
    <slot />
</main>
<footer>
    <div class="h-[5rem]"></div>
    <div class="w-full fixed bottom-0">
        <RadioMetrics />
    </div>
</footer>
