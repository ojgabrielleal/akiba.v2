<script>
    export let close = () => {};
    export let repositoryId = null ;

    import { onMount } from 'svelte';
    import { useForm } from "@inertiajs/svelte";
    import { Preview } from "@/components/private";

    let form = useForm({
        _method: null,
        image: null,
        name: null,
        category: null,
        file: null
    });

    onMount(()=>{
        if (repositoryId) {
            axios.get(`/painel/marketing/get/repository/${repositoryId}`).then((response) => {
                $form._method = "PUT"
                $form.image = response.data.image;
                $form.name = response.data.name;
                $form.category = response.data.category;
                $form.file = response.data.file;
            });
        }
    });

    function onSubmit(){
        let url = repositoryId ? `/painel/marketing/update/repository/${repositoryId}` : '/painel/marketing/create/repository';
        $form.post(url, {
            onSuccess: ()=>close()
        });
    }
</script>

<form on:submit|preventDefault={onSubmit}>
    <div class="mb-4">
        <Preview 
            name="image" 
            standard="w-full h-[10rem] rounded-lg"
            src={$form.image}
            oninput={event => $form.image = event.target.files[0]}
            required={true}
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
            Nome do arquivo
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
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="category">
            Categoria do arquivo
        </label>
        <select 
            id="category" 
            name="category"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.category}
            required
        >
            <option value="tutorials">Tutoriais</option>
            <option value="installers">Instaladores</option>
            <option value="packages">Pacotes e modelos</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="file">
            URL do conteúdo hospedado externamente
        </label>
        <input 
            id="file"
            type="url" 
            name="file" 
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400" 
            bind:value={$form.file}
            required
        />
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        {#if repositoryId}
            Atualizar
        {:else}
            Cadastrar
        {/if}
    </button>
</form>