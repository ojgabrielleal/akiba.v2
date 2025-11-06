<script>
    import { Notification } from "@/components/admin";
    import { Navbar } from "@/widgets/admin/navbar";
    import { Status } from "@/widgets/admin/status";
    document.body.style.backgroundColor = "var(--color-blue-indigo)";
</script>


<Notification/>
<header class="mb-15 lg:pt-10">
    <Navbar />
    <slot name="header" />
</header>
<main class="container">
    <slot />
</main>
<footer>
    <div class="h-[5rem]"></div>
    <div class="w-full fixed bottom-0">
        <Status />
    </div>
</footer>
