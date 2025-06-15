<script>
    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Auth } from "@/Widgets/Form";
</script>

<Meta meta={{ title: "Realize o Login" }} />
<Layout>
    <div
        class="relative flex min-h-screen items-center justify-center bg-cover bg-center"
        style="background-image: url('/img/loginBackground.jpg')"
    >
        <!-- Overlay escura -->
        <div class="absolute inset-0 bg-black opacity-50"></div>

        <!-- Conteúdo principal -->
        <div class="relative flex w-full max-w-xs flex-col items-center px-4">
            <img src="/img/logo.png" alt="Logo" class="w-[11rem]" />
            <strong
                class="font-noto-sans mb-4 mt-10 text-lg font-light text-[var(--color-neutral-aurora)]"
            >
                Faça login para acessar o sistema
            </strong>
            <Auth submit="/painel" />
        </div>
    </div>
</Layout>
