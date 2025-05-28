<script>
    export let submitTo;

    import Icon from "@iconify/svelte";
    import axios from "axios";
    import { router } from "@inertiajs/svelte";

    import { toast } from "@/Utils/Toasts";
    import { Input } from "@/Components/Form";

    let username = "";
    let password = "";

    function handleSubmit() {
        axios
            .post(submitTo, { username, password })
            .then((response) => {
                router.visit(response.data.redirect);
            })
            .catch((error) => {
                toast({
                    message: error.response.data.error,
                    type: "error",
                });
            });
    }
</script>

<form on:submit|preventDefault={handleSubmit} class="w-full">
    <Input
        bind:value={username}
        type="text"
        id="username"
        styles="font-noto-sans border-black-200 border-b-black-500 h-[5rem] w-full rounded-t-2xl border-b bg-[var(--color-neutral-aurora)] p-4 outline-none"
        placeholder="Usuário"
        ariaLabel="usuário"
    />
    <Input
        bind:value={password}
        type="password"
        id="password"
        styles="font-noto-sans h-[5rem] w-full rounded-b-2xl bg-[var(--color-neutral-aurora)] p-4 outline-none"
        placeholder="Senha"
        ariaLabel="senha"
    />
    <button
        type="submit"
        class="cursor-pointer font-noto-sans mt-4 flex h-[5rem] w-full items-center justify-center gap-1 rounded-2xl bg-[var(--color-blue-skywave)] pt-1 text-lg font-light text-[var(--color-neutral-aurora)]"
        aria-label="entrar"
    >
        <Icon icon="fa6-solid:arrow-right-to-bracket" />Entrar
    </button>
</form>
