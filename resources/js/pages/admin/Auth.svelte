<script>
    import { page } from "@inertiajs/svelte";
    import Icon from "@iconify/svelte";
    import { Meta } from "@/meta";
    import { AuthForm } from "@/widgets/admin/form";

    $: ({ flash } = $page.props);
</script>

<Meta meta={{ title: "Realize o Login" }} />
<div
    class="relative flex min-h-screen items-center justify-center bg-cover bg-center"
    style="background-image: url('/img/default/loginBackground.jpg')"
>
    <!-- Overlay escura -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Conteúdo principal -->
    <div class="relative flex w-full max-w-xs flex-col items-center px-4">
        <img src="/img/default/logo.png" alt="Logo" class="w-[11rem]" />
        <strong
            class="font-noto-sans mb-4 mt-10 text-lg font-light text-neutral-aurora"
        >
            Faça login para acessar o sistema
        </strong>
        <AuthForm />
        {#if flash}
            <div
                class={`bg-[#B91C1C] flex justify-center items-center gap-2  w-full mt-5 p-4 rounded-lg font-noto-sans font-light text-neutral-aurora transition-opacity duration-500 ease-in-out ${flash.message ? "opacity-100" : "opacity-0"}`}
            >
                <Icon icon="mingcute:close-fill" width="24" height="24" />
                {@html flash.message}
            </div>
        {/if}
    </div>
</div>
