<script>
    import { useForm, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Preview, Wysiwyg } from "@/components/admin";

    $: ({ podcast } = $page.props);

    $: form = useForm({
        _method: null,
        image: podcast?.image,
        season: podcast?.season, 
        episode: podcast?.episode,
        title: podcast?.title,
        summary: podcast?.summary,
        description: podcast?.description,
        audio: podcast?.audio,
    });

    function onSubmit(event){
        event.preventDefault();

        if(podcast){
            $form._method = "PUT";
            $form.post(`/painel/podcasts/update/${podcast.id}`);
        }else{
            $form.post('/painel/podcasts/create/', {
                preserveState: false,
                onSuccess: () => {
                    $form.reset();
                },
            });
        }
    }
</script>

<Section title={podcast ? "Editar Podcast" : "Adicionar Podcast"}>
    <form class="mt-10" on:submit={onSubmit}>
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr] gap-8 mb-8">
            <div>
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Capa do podcast
                </div>
                <Preview  
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
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
