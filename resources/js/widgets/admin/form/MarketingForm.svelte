<script>
    export let close = () => {};
    export let repository_id = null ;

    import { onMount } from 'svelte';
    import { useForm } from "@inertiajs/svelte";
    import { Preview } from "@/components/admin";

    $: form = useForm({
        _method: null,
        image: null,
        name: null,
        category: null,
        file: null
    });

    function onSubmit(event){
        event.preventDefault();

        if(repository_id){
            $form._method = "PUT"
            $form.post(`/painel/marketing/update/repository/${repository_id}`, {
                onSuccess: ()=> close()
            });
        }else{
            $form.post('/painel/marketing/create/repository', {
                onSuccess: ()=>close()
            });
        }
    }

    onMount(()=>{
        if (repository_id) {
            axios.get(`/painel/marketing/get/repository/${repository_id}`).then((response) => {
                $form.image = response.data.image;
                $form.name = response.data.name;
                $form.category = response.data.category;
                $form.file = response.data.file;
            });
        }
    });
</script>

<form onsubmit={onSubmit}>
    <div class="mb-4">
        <Preview 
            name="image" 
            standard="w-full h-[10rem] rounded-lg"
            src={$form.image}
            oninput={event => $form.image = event.target.files[0]}
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
        {#if repository_id}
            Atualizar
        {:else}
            Cadastrar
        {/if}
    </button>
</form>