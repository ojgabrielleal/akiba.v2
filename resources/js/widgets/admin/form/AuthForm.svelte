<script>
    import { useForm, router } from "@inertiajs/svelte";

    let form = useForm({
        username: null,
        password: null,
    });

    function onSubmit(event) {
        event.preventDefault();
        $form.post("/painel/authenticate");
    }
</script>                   

<form on:submit={onSubmit} class="w-full">
    <input 
        type="text" 
        name="username" 
        placeholder="Usuário" 
        class="font-noto-sans border-black-200 border-b-black-500 h-[5rem] w-full rounded-t-2xl border-b bg-neutral-aurora p-4 outline-none" 
        bind:value={$form.username}
    />
    <input 
        type="password" 
        name="password" 
        placeholder="Senha" 
        class="font-noto-sans h-[5rem] w-full rounded-b-2xl bg-neutral-aurora p-4 outline-none" 
        bind:value={$form.password}
    />
    <button type="submit" class="cursor-pointer font-noto-sans mt-4 flex h-[5rem] w-full items-center justify-center gap-1 rounded-2xl bg-blue-skywave pt-1 text-lg font-light text-neutral-aurora">
        Entrar
    </button>
</form>
