<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import toast, { Toaster } from "svelte-hot-french-toast"
    import { LoginForm } from "@/ui/widgets/private/form";

    $: ({ flash } = $page.props);

    $: if(flash){
        toast(flash.message, {
            icon: flash.icon
        });
    }
</script>

<Meta meta={{ title: "Realize o Login" }} />
<Toaster />
<div class="w-screen h-screen flex justify-center items-center bg-blue-indigo p-5">
    <section class="bg-neutral-aurora rounded-l-lg rounded-xl shadow-xl/30 xl:w-[60rem] xl:h-[30rem] xl:grid xl:grid-cols-[2fr_3fr]">
        <div class="flex items-center p-8">
            <LoginForm/>
        </div>
        <div class="h-full overflow-hidden rounded-r-lg hidden xl:block">
            <img class="w-full h-full object-cover" src="/img/login/default/banner.gif" alt="" aria-hidden="true"/>
        </div>
    </section>
</div>