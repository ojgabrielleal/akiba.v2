<script>
    export let close = () => {};

    import { useForm } from "@inertiajs/svelte";

    let form = useForm({
       username: null,
       password: null, 
       name: null,
       nickname: null,
       gender: null, 
       permission: null,
    });

    function onSubmit(){
        $form.post('/painel/adms/create/user', {
            onSuccess: () => close()
        });
    }
</script>

<form on:submit|preventDefault={onSubmit}>
    <div class="flex items-center justify-center w-full mb-5">
        <div class="relative w-full">
            <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                Acessos
            </span>
            <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
        </div>
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="username">
            Login
        </label>
        <input
            id="username"
            type="text"
            name="username"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.username}
            required
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="password">
            Senha
        </label>
        <input
            id="password"
            type="password"
            name="password"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.password}
            required
        />
        <div class="text-sm font-noto-sans text-gray-400 mt-1">
            Essa senha será criptografada para proteção
        </div>
    </div>
        <div class="mb-10">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="permission">
            Cargo principal
        </label>
        <select
            id="permission"
            name="permission"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.permission}
            required
        >
            <option value="administrator">Administrador</option>
            <option value="dev">Dev</option>
            <option value="streamer">Streamer</option>
            <option value="writer">Colunista</option>
            <option value="podcaster">Podcaster</option>
            <option value="marketing">Merketing</option>
        </select>
    </div>
    <div class="flex items-center justify-center w-full mb-5">
        <div class="relative w-full">
            <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                Básico
            </span>
            <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
        </div>
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
            Nome
        </label>
        <input
            id="name"
            type="text"
            name="name"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.name}
            required
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="nickname">
            Apelido
        </label>
        <input
            id="nickname"
            type="text"
            name="nickname"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.nickname}
            required
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="gender">
            Gênero
        </label>
        <select
            id="gender"
            name="gender"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.gender}
            required
        >
            <option value="male">Masculino</option>
            <option value="female">Feminino</option>
        </select>
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Cadastrar
    </button>
</form>