<script>
    import { useForm, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin";
    import { Preview, Wysiwyg } from "@/components/admin";
    import Tags from "@/data/admin/Tags";

    $: ({ user, publication } = $page.props);

    $: form = useForm({
        status: null,
        image: publication?.image,
        title: publication?.title,
        cover: publication?.cover,
        content: publication?.content,
        first_category: publication?.categories[0]?.category_name,
        second_category: publication?.categories[1]?.category_name,
        first_reference_name: publication?.references[0]?.name,
        first_reference_url: publication?.references[0]?.url,
        second_reference_name: publication?.references[1]?.name,
        second_reference_url: publication?.references[1]?.url,
    });

    function onSubmit(event) {
        event.preventDefault();

        const submitter = event.submitter;
        const url = publication ? `/painel/materias/update/${publication.id}` : `/painel/materias/create`;

        $form.status = submitter.value
        $form.post(url);
    }
</script>

<Section title={publication ? "Editar matéria" : "Criar matéria"}>
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
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Imagem em destaque
                </div>
                <Preview 
                    name="image" 
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                />
            </div>
            <div class="mb-3">
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                        Título
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
                        Capa da matéria
                    </label>
                    <Preview 
                        name="cover" 
                        src={$form.cover}  
                        oninput={event => $form.cover = event.target.files[0]} 
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sua matéria
                    </label>
                    <Wysiwyg 
                        name="content" 
                        bind:value={$form.content} 
                    />
                </div>
            </div>
        </div>
        <div class="w-full xl:w-[85rem] ml-auto">
            <div class="gap-2 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="first_category">
                        Primeira Tag
                    </label>
                    <select
                        id="first_category"
                        name="first_category"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg"
                        bind:value={$form.first_category}
                    >
                        {#each Tags as tag}
                            <option value={tag.value}>{tag.label}</option>
                        {/each}
                    </select>
                </div>
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="second_category">
                        Segunda Tag
                    </label>
                    <select
                        id="second_category"
                        name="second_category"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg"
                        bind:value={$form.second_category}
                    >
                        {#each Tags as tag}
                            <option value={tag.value}>{tag.label}</option>
                        {/each}
                    </select>
                </div>
            </div>
            <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Primeira fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="first_reference_name">
                            Nome:
                        </label>
                        <input
                            id="first_reference_name"
                            type="text"
                            name="first_reference_name"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.first_reference_name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="first_reference_url">
                            Link:
                        </label>
                        <input
                            id="first_reference_url"
                            type="text"
                            name="first_reference_url"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.first_reference_url}
                        />
                    </div>
                </div>
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Segunda fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="second_reference_name">
                            Nome:
                        </label>
                        <input
                            id="second_reference_name"
                            type="text"
                            name="second_reference_name"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.second_reference_name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="second_reference_url">
                            Link:
                        </label>
                        <input
                            id="second_reference_url"
                            type="text"
                            name="second_reference_url"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.second_reference_url}
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-15">
            {#if publication?.status === "published"}
                <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                    Atualizar
                </button>
            {:else}
                <button type="submit" value="sketch" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    Salvar como Rascunho
                </button>
                <button type="submit" value="revision" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase">
                    Mandar para revisão
                </button>
                {#if user.permissions_keys?.includes("administrator")}
                    <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                        Publicar
                    </button>
                {/if}
            {/if}
        </div>
    </form>
</Section>