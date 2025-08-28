<script>
    import { router, page } from "@inertiajs/svelte";
    import { Preview, Wysiwyg } from "@/components/admin";

    import Tags from "@/data/admin/Tags";

    $: ({ user, publication } = $page.props);

    // Submit the post from controller backend
    $: formData = {
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
    }

    function onSubmit(event) {
        event.preventDefault();

        const submitter = event.submitter;
        formData.status = submitter.value;

        const url = publication ? `/painel/materias/update/${publication.slug}` : `/painel/materias/create`;
        router.post(url, formData);
    }
</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" src={formData.image} />
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                    Título
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                    bind:value={formData.title}
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                    Capa da matéria
                </label>
                <Preview
                    name="cover"
                    previewHeight="max-h-[30rem]"
                    src={formData.cover}
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                    Escreva sua matéria
                </label>
                <Wysiwyg value={formData.content} name="content" />
            </div>
        </div>
    </div>
    <div class="w-full xl:w-[85rem] ml-auto mb-10">
        <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
            <div class="mb-8">
                <label class="text-blue-skywave font-bold italic text-lg text-center uppercase font-noto-sans block mb-1" for="first_category">
                    Primeira Tag
                </label>
                <select
                    id="first_category"
                    name="first_category"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg"
                    options={Tags}
                    bind:value={formData.first_category}
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
                    bind:value={formData.second_category}
                >
                    {#each Tags as tag}
                        <option value={tag.value}>{tag.label}</option>
                    {/each}
                </select>
            </div>
        </div>
        <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
            <div class="mb-8">
                <span class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Primeira fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="first_reference_name">
                        Nome:
                    </label>
                    <input
                        type="text"
                        id="first_reference_name"
                        name="first_reference_name"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={formData.first_reference_name}
                    />
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="first_reference_url">
                        Link:
                    </label>
                    <input
                        type="text"
                        id="first_reference_url"
                        name="first_reference_url"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={formData.first_reference_url}
                    />
                </div>
            </div>
            <div class="mb-8">
                <span class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Segunda fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center mb-4">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="second_reference_name">
                        Nome:
                    </label>
                    <input
                        type="text"
                        id="second_reference_name"
                        name="second_reference_name"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={formData.second_reference_name}
                    />
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="second_reference_url">
                        Link:
                    </label>
                    <input
                        type="text"
                        id="second_reference_url"
                        name="second_reference_url"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={formData.second_reference_url}
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        {#if publication?.status === "published"}
            <button type="submit" aria-label="status" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                Atualizar matéria
            </button>
        {:else}
            <button type="submit" aria-label="status" value="sketch" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                Salvar como Rascunho
            </button>
            <button type="submit" aria-label="status" value="revision" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl font-bold font-noto-sans italic uppercase">
                Mandar para revisão
            </button>
            {#if user.permissions_keys?.includes("administrator")}
                <button type="submit" aria-label="status" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                    Publicar
                </button>
            {/if}
        {/if}
    </div>
</form>
