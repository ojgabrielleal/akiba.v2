<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin/";
    import { Auth } from "@/widgets/admin/form";
</script>

<Meta meta={{ title: "Realize o Login" }} />
<div class="relative flex min-h-screen items-center justify-center bg-cover bg-center" style="background-image: url('/img/loginBackground.jpg')">
    <!-- Overlay escura -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Conteúdo principal -->
    <div class="relative flex w-full max-w-xs flex-col items-center px-4">
        <img src="/img/logo.png" alt="Logo" class="w-[11rem]" />
        <strong class="font-noto-sans mb-4 mt-10 text-lg font-light text-neutral-aurora">
            Faça login para acessar o sistema
        </strong>
        <Auth/>
    </div>
</div>
