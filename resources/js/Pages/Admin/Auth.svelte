<script>
    import { Meta } from '@/Meta';
    import { FormAuth } from '@/Widgets/Form';

    // Props to components
    let metatags = {
        title: 'Realize o Login',
    }

    let formAuth = { 
        submit: "/painel"
    }
</script>

<Meta meta={{metatags}} />
<div class="relative flex min-h-screen items-center justify-center bg-cover bg-center" style="background-image: url('/img/loginBackground.jpg')">
    <!-- Overlay escura -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Conteúdo principal -->
    <div class="relative flex w-full max-w-xs flex-col items-center px-4">
        <img src="/img/logo.png" alt="Logo" class="w-[11rem]" />
        <strong class="font-noto-sans mb-4 mt-10 text-lg font-light text-[var(--color-neutral-aurora)]"> Faça login para acessar o sistema </strong>
        <FormAuth data={formAuth}/>
    </div>
</div>
