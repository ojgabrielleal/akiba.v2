<script>
    import { useForm, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin";
    import { Preview, Wysiwyg } from "@/components/admin";

    $: ({ publication } = $page.props);

    // Submit the eent from controller backende 
    $: form = useForm({
        image: publication?.image,
        title: publication?.title,
        cover: publication?.cover,
        content: publication?.content,
        dates: publication?.dates,
        address: publication?.address,
    });

    function onSubmit(event) {
        event.preventDefault();

        const submitter = event.submitter;
        const url = publication ? `/painel/eventos/update/${publication.slug}` : `/painel/eventos/create`;

        $form.status = submitter.value
        $form.post(url);
    }

</script>

<Section title="Criar Eventos">
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        <a href="/painel/materias" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Matérias
        </a>
        <a href="/painel/reviews" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Reviews
        </a>
        <a href="/painel/eventos" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Eventos
        </a>
    </div>
    <form class="mt-10 xl:mt-25" on:submit={onSubmit}>
        <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
            <div class="mb-3">
                <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                    Imagem em destaque
                </span>
                <Preview 
                    name="image" 
                    view="w-full max-h-[24rem]"
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                />
            </div>
            <div class="mb-3">
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                        Nome do evento
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
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                        Capa do evento
                    </label>
                    <Preview 
                        name="cover" 
                        view="max-h-[30rem]" 
                        src={$form.cover}  
                        oninput={event => $form.cover = event.target.files[0]} 
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sobre o evento
                    </label>
                    <Wysiwyg 
                        name="content" 
                        bind:value={$form.content} 
                    />
                </div>
            </div>
        </div>
        <div class="w-full xl:w-[85rem] ml-auto mb-8">
            <div class="gap-3 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
                <div class="mb-8">
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="local">
                            Local:
                        </label>
                        <input
                            id="local"
                            type="text"
                            name="local"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.address}
                        />
                    </div>
                </div>
                <div class="mb-8">
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="datas">
                            Datas:
                        </label>
                        <input
                            id="datas"
                            type="text"
                            name="datas"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.dates}
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
            <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                {#if publication}
                    Atualizar 
                {:else}
                    Publicar 
                {/if}
            </button>
        </div>
    </form>
</Section>
