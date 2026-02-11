<script>
    import { onMount } from "svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Preview, Wysiwyg } from "@/ui/components/private";

    $: ({ podcast } = $page.props);

    let form = useForm({
        _method: null,
        image: null,
        season: null,
        episode: null,
        title: null,
        summary: null,
        description: null,
        audio: null,
    });

    onMount(()=>{
        if(podcast){
            $form._method = "PUT";
            $form.image = podcast.image,
            $form.season = podcast.season, 
            $form.episode = podcast.episode,
            $form.title = podcast.title,
            $form.summary = podcast.summary,
            $form.description = podcast.description,
            $form.audio = podcast.audio
        }
    })

    function submit(){
        let url = podcast ? `/painel/podcasts/update/${podcast.id}` : '/painel/podcasts/create/'
        $form.post(url, {
            preserveState: podcast,
            onSuccess: () => {
                podcast ? null : $form.reset();
            },
        });
        
    }
</script>

<Section title={podcast ? "Editar Podcast" : "Adicionar Podcast"}>
    <form on:submit|preventDefault={submit} class="mt-10">
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr] gap-8 mb-8">
            <div>
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Capa do podcast
                </div>
                <Preview  
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                    required={podcast ? false : true}
                />
            </div>
            <div class="flex flex-col gap-8">
                <div class="grid grid-cols-1 xl:grid-cols-[9rem_9rem_1fr] gap-8 lg:gap-5">
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="season">
                            Season
                        </label>  
                        <input
                            id="season"
                            type="number"
                            name="season"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.season}
                            required
                        />                  
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="episode">
                            Episode
                        </label>  
                        <input
                            id="episode"
                            type="number"
                            name="episode"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.episode}
                            required
                        />                  
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                            Título do episódio
                        </label>  
                        <input
                            id="title"
                            type="text"
                            name="title"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.title}
                            required
                        />                  
                    </div>
                </div>
                <div>
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="summary">
                        Resumo do episódio
                    </label>  
                    <Wysiwyg
                        height="13rem"
                        name="summary"
                        bind:value={$form.summary}
                        required={true}
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="description">
                    Escreva sobre o episódio
                </label> 
                <Wysiwyg
                    height="25rem"
                    name="description"
                    bind:value={$form.description}
                    required={true}
                />
            </div>
            <div>
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="audio">
                    URL Embeded do Spotify do episódio
                </label> 
                <input
                    id="audio"
                    type="url"
                    name="audio"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                    bind:value={$form.audio}
                    required
                /> 
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                {#if podcast}
                    Atualizar
                {:else}
                    Publicar 
                {/if}
            </button>
        </div>
    </form>
</Section>
