<script>
    export let close = () => {};
    export let userId = null;

    import { onMount } from "svelte";
    import { useForm } from "@inertiajs/svelte";
    import axios from "axios";

    let formPassword = useForm({
        password: null
    });

    let formPermissions = useForm({
        permissions_keys: null
    });

    function onSubmitPassword(){
        $formPassword.put(`/painel/adms/update/user/password/${userId}`, {
            onSuccess: () => close()
        });
    }

    function onSubmitPermissions(){
        $formPermissions.put(`/painel/adms/update/user/permissions/${userId}`, {
            onSuccess: () => close()
        });
    }

    onMount(()=>{
        if(userId){
            axios.get(`/painel/adms/get/user/${userId}`)
            .then((response)=>{
                $formPermissions.permissions_keys = response.data.permissions_keys;
            }).catch((error)=>{
                console.log('Error ao buscar dados do usuário solicitado', error);
            })
        }
    });
</script>

<form on:submit|preventDefault={onSubmitPassword}>
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
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="password">
            Nova senha
        </label>
        <input
            id="password"
            type="password"
            name="password"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$formPassword.password}
        />
        <div class="text-sm font-noto-sans text-gray-400 mt-1">
            Essa senha será criptografada para proteção
        </div>
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Atualizar
    </button>
</form>
<form on:submit|preventDefault={onSubmitPermissions}>
    <div class="flex items-center justify-center w-full mt-8 mb-5">
        <div class="relative w-full">
            <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                Permissões
            </span>
            <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
        </div>
    </div>
    <div class="mb-4">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="administrator" 
                    id="administrator"
                    value="administrator"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="administrator">
                    <div class="text-sm font-noto-sans font-semibold">
                        Administrador
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso completo ao sistema
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="dev" 
                    id="dev"
                    value="dev"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="dev">
                    <div class="text-sm font-noto-sans font-semibold">
                        Dev
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso completo a funções e dados técnicos do sistema
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="streamer" 
                    id="streamer"
                    value="streamer"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="streamer">
                    <div class="text-sm font-noto-sans font-semibold">
                        Locutor
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso para entrar no ar e controle dos pedidos
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="writer" 
                    id="writer"
                    value="writer"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="writer">
                    <div class="text-sm font-noto-sans font-semibold">
                        Colunista
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso a redação e eventos
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="podcaster" 
                    id="podcaster"
                    value="podcaster"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="podcaster">
                    <div class="text-sm font-noto-sans font-semibold">
                        Podcaster
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso completo a podcasts
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="marketing" 
                    id="marketing"
                    value="marketing"
                    bind:group={$formPermissions.permissions_keys}
                >
                <label for="marketing">
                    <div class="text-sm font-noto-sans font-semibold">
                        Marketing
                    </div>
                    <div class="text-xs text-gray-400 font-noto-sans">
                        Acesso a diversos modelos e conteúdos para criação
                    </div>
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Atualizar
    </button>
</form>