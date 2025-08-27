<script>
    export let submit = "/painel/authenticate";

    import Icon from "@iconify/svelte";
    import { router } from "@inertiajs/svelte";

    // Submit the form to backend
    let username = "";
    let password = "";

    function handleSubmit() {
       router.post(submit, {username: username, password: password})
    }
</script>

<form on:submit|preventDefault={handleSubmit} class="w-full">
    <input 
        bind:value={username}
        type="text"
        name="username"
        class="font-noto-sans border-black-200 border-b-black-500 h-[5rem] w-full rounded-t-2xl border-b bg-neutral-aurora p-4 outline-none"
        placeholder="Usuário"
    />
    <input 
        bind:value={password}
        type="password"
        name="password"
        class="font-noto-sans h-[5rem] w-full rounded-b-2xl bg-neutral-aurora p-4 outline-none"
        placeholder="Senha"
    />
    <button type="submit" class="cursor-pointer font-noto-sans mt-4 flex h-[5rem] w-full items-center justify-center gap-1 rounded-2xl bg-blue-skywave pt-1 text-lg font-light text-neutral-aurora" aria-label="entrar">
        <Icon icon="fa6-solid:arrow-right-to-bracket" />Entrar
    </button>
</form>
