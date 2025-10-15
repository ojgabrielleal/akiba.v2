<script>
    import { page, useForm } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin";
    import { Preview, Wysiwyg } from "@/components/admin";

    $: ({ user, publication } = $page.props);

    $: authorSelected = user.id;
    $: contentSelected = publication?.reviews?.find(
        (item) => item.user.id === authorSelected,
    );

    $:form = useForm({
        image: publication?.image,
        title: publication?.title,
        sinopse: publication?.sinopse,
        cover: publication?.cover,
        content: contentSelected?.content,
        content_id: null,
    })
    function onSubmit(event) {
        event.preventDefault();

        const url = publication ? `/painel/reviews/update/${publication.id}` : `/painel/reviews/create`;
        
        $form.content_id = contentSelected?.id;
        $form.post(url, {
            preserveState: false,
            onSuccess: () => {
                if (!publication) {
                    $form.image = null,
                    $form.title = null,
                    $form.sinopse = null,
                    $form.cover = null,
                    $form.content = null,
                    $form.content_id = null
                }
            },
        });
    }
</script>

<Section title={publication ? "Editar review" : "Criar review"}>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        <a href="/painel/materias" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Matérias
        </a>
        <a href="/painel/reviews" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Reviews
        </a>
        <a href="/painel/eventos" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Eventos
        </a>
    </div>        
    <form class="mt-10 xl:mt-25" on:submit={onSubmit}>
        <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                    Imagem em destaque
                </div>
                <Preview 
                    name="image" 
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                />        
            </div>
            <div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                        Nome do anime
                    </label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.title}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="sinopse">
                        Sinopse do anime
                    </label>
                    <Wysiwyg
                        height="15rem"
                        name="sinopse"
                        bind:value={$form.sinopse}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                        Capa do anime
                    </label>
                    <Preview 
                        name="cover" 
                        src={$form.cover} 
                        oninput={event => $form.cover = event.target.files[0]} 
                    />   
                </div>
                <div>
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sobre o anime
                    </label>
                    {#if user.permissions_keys.includes("administrator") && publication}
                        <div class="flex mb-3 mt-2 gap-2">
                            {#each publication?.reviews as item}
                                <div class="relative inline-block mb-2">
                                    <button type="button" class="py-2 px-6 rounded-md uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer relative {item.user.id === authorSelected ? 'bg-neutral-aurora text-blue-ocean' : 'bg-blue-ocean text-neutral-aurora'}" on:click={() => (authorSelected = item.user.id)}>
                                        {item.user.nickname}
                                    </button>
                                    {#if item.user.id === authorSelected}
                                        <span class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px] border-t-neutral-aurora">
                                        </span>
                                    {/if}
                                </div>
                            {/each}
                        </div>
                    {/if}
                    <Wysiwyg name="content" bind:value={$form.content} />
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                Publicar
            </button>
        </div>
    </form>
</Section>