<script>
    import { Notification } from "@/ui/components/private";
    import { Navbar } from "@/ui/widgets/private/navbar";
    import { RadioMetrics } from "@/ui/widgets/private/metrics";

    document.body.style.backgroundColor = "var(--color-blue-indigo)";
</script>


<Notification/>
<header class="mb-15 lg:pt-10">
    <Navbar />
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
