<script>

    import { useForm, Link, page } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Preview, Wysiwyg } from "@/ui/components/private";
    import { hasPermission } from "@/utils";
    import tags from "@/data/posts/tags.json";

    $: ({ post } = $page.props);

    let permissions = {
        show_button_create: hasPermission('post.create'),
        show_button_update: hasPermission('post.update') && hasPermission('post.update.own'),
    }

    let form = useForm({
        _method: 'POST',
        status: null,
        image: null,
        title: null,
        cover: null,
        content: null,
        categories:  [
            {uuid: null},
            {name: null},
        ],
        references: [
            {uuid: null, name: null, url: null},
            {uuid: null, name: null, url: null}
        ]
    });
    
    $: if(post){
        $form._method = 'PATCH';
        $form.status = post.data.status;
        $form.image = post.data.image;
        $form.title = post.data.title;
        $form.cover = post.data.cover;
        $form.content = post.data.content;
        $form.categories = post.data.categories.map(({uuid, name}) => ({ uuid, name }));
        $form.references = post.data.references.map(({uuid, name, url}) => ({ uuid, name, url }))
    }

    const submit = (event) => {
        let url = post ? `/painel/materias/${post.data.uuid}` : '/painel/materias';
        
        $form.status = event.submitter.value;
        $form.post(url, {
            preserveState: post,
            onSuccess: () => {
                post ? null : $form.reset()
            }
        });
    }
</script>

<Section title={post ?  "Editar matéria" : "Criar matéria"}>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        <Link preserveState={false} href="/painel/materias" class="cursor-pointer border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-center text-xl uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Matérias
        </Link>
        <Link preserveState={false} href="/painel/reviews" class="cursor-pointer border-4 border-solid border-purple-mystic rounded-xl text-purple-mystic text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Reviews
        </Link>
        <Link preserveState={false} href="/painel/eventos" class="cursor-pointer border-4 border-solid border-orange-copper rounded-xl text-orange-copper text-xl text-center uppercase italic font-noto-sans font-bold w-full lg:w-auto py-2 px-6">
            Eventos
        </Link>
    </div>
    <form on:submit|preventDefault={submit} class="mt-10 xl:mt-15">
        <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Imagem em destaque
                </div>
                <Preview 
                    name="image" 
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                    required={!post}
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
                        viewobject="object-cover"
                        src={$form.cover}  
                        oninput={event => $form.cover = event.target.files[0]} 
                        required={!post}
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sua matéria
                    </label>
                    <Wysiwyg 
                        name="content" 
                        bind:value={$form.content} 
                        required={true}
                    />
                </div>
            </div>
        </div>
        <div class="w-full xl:w-[80rem] 2xl:w-[85rem] ml-auto">
            <div class="gap-2 grid grid-cols-1 md:grid-cols-2 md:gap-10">
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="categories">
                        Primeira Tag
                    </label>
                    <select
                        id="categories"
                        name="categories"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg"
                        bind:value={$form.categories[0].name}
                    >
                        {#each tags as tag}
                            <option value={tag.value}>{tag.label}</option>
                        {/each}
                    </select>
                </div>
                <div class="mb-8">
                    <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="categories">
                        Segunda Tag
                    </label>
                    <select
                        id="categories"
                        name="categories"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg"
                        bind:value={$form.categories[1].name}
                    >
                        {#each tags as tag}
                            <option value={tag.value}>{tag.label}</option>
                        {/each}
                    </select>
                </div>
            </div>
            <div class="gap-5 grid grid-cols-1 lg:grid-cols-2 lg:gap-10">
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Primeira fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Nome:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[0].name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Link:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[0].url}
                        />
                    </div>
                </div>
                <div>
                    <div class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                        Segunda fonte de pesquisa
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Nome:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[1].name}
                        />
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                        <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="references">
                            Link:
                        </label>
                        <input
                            id="references"
                            type="text"
                            name="references"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.references[1].url}
                        />
                    </div>
                </div>
            </div>
        </div>
        {#if (permissions.show_button_create || permissions.show_button_update)}
            <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-15">
                <button type="submit" value="sketch" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    {post?.status === 'sketch' ? 'Atualizar rascunho' : 'Salvar como rascunho'}
                </button>
                {#if post?.status !== 'revision' && post?.status !== 'published'}
                    <button type="submit" value="revision" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase">
                        Mandar pra revisão
                    </button>
                {/if}
                <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                    {post?.status === 'published' ? 'Atualizar matéria' : 'Publicar matéria'}
                </button>
            </div>
        {/if}
    </form>
</Section>