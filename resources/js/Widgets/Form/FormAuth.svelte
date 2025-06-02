<script>
    export let data = {};

    import Icon from "@iconify/svelte";
    import axios from "axios";
    import toast from "svelte-hot-french-toast"
    import { router } from "@inertiajs/svelte";

    import { Input } from "@/Components/Form";

    // Submit the form to backend
    let username = "";
    let password = "";

    function handleSubmit() {
        axios.post(data.submit, { username, password })
            .then((response) => {
                router.visit(response.data.redirect);
            })
            .catch((error) => {
                toast.error(error.response.data.error);
            });
    }

    // Props to components 
    let inputUsername = { 
        value: username,
        type: "text",
        id: "username",
        class: "font-noto-sans border-black-200 border-b-black-500 h-[5rem] w-full rounded-t-2xl border-b bg-[var(--color-neutral-aurora)] p-4 outline-none",
        placeholder: "Usuário",
        arialabel: "usuário"
    }

    let inputPassword = {
        value: password,
        type: "password",
        id: "password",
        class: "font-noto-sans h-[5rem] w-full rounded-b-2xl bg-[var(--color-neutral-aurora)] p-4 outline-none",
        placeholder: "Senha",
        arialabel: "senha"
    }
</script>

<form on:submit|preventDefault={handleSubmit} class="w-full">
    <Input data={inputUsername}/>
    <Input data={inputPassword}/>
    <button type="submit" class="cursor-pointer font-noto-sans mt-4 flex h-[5rem] w-full items-center justify-center gap-1 rounded-2xl bg-[var(--color-blue-skywave)] pt-1 text-lg font-light text-[var(--color-neutral-aurora)]" aria-label="entrar">
        <Icon icon="fa6-solid:arrow-right-to-bracket" />Entrar
    </button>
</form>
