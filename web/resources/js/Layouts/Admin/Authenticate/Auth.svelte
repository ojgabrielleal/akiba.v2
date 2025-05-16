<script>
    import Icon from "@iconify/svelte";
    import { page, router } from "@inertiajs/svelte";
    import { Input } from "@/Components/Forms";
    export let submitTo;

    // Define a function to handle form submission
    let username = "";
    let password = "";

    function handleSubmit() {
       router.post(submitTo, {
            _token: $page.props.csrfToken,
            username,
            password,
        });
    }
</script>

<form on:submit|preventDefault={handleSubmit} class="w-full">
    <Input
        bind:value={username}
        type="text"
        id="username"
        className="font-noto-sans border-black-200 border-b-black-500 h-[5rem] w-full rounded-t-2xl border-b bg-[var(--color-neutral-aurora)] p-4 outline-none"
        placeholder="Usuário"
    />
    <Input
        bind:value={password}
        type="password"
        id="password"
        className="font-noto-sans h-[5rem] w-full rounded-b-2xl bg-[var(--color-neutral-aurora)] p-4 outline-none"
        placeholder="Senha"
    />
    <button
        type="submit"
        class="cursor-pointer font-noto-sans mt-4 flex h-[5rem] w-full items-center justify-center gap-1 rounded-2xl bg-[var(--color-blue-skywave)] pt-1 text-lg font-light text-[var(--color-neutral-aurora)]"
    >
        <Icon icon="fa6-solid:arrow-right-to-bracket" />Entrar
    </button>
</form>
