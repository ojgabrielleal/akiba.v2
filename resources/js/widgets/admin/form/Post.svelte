<script>
    import { router, page } from "@inertiajs/svelte";
    import { Preview, Label, Input, Wysiwyg, Select } from "@/components/admin/form";
    import { Button } from "@/components/admin/button";

    import Tags from "@/data/admin/Tags";

    $:({ user, post } = $page.props);

    // Submit the post from controller backend
    function onSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        // pega o botão que submeteu o form
        const submitter = event.submitter;
        console.log(submitter.value)
        formData.set('status', submitter.value);

        if (post) {
            router.post(`/painel/materias/update/${post.slug}`, formData);
        } else {
            router.post(`/painel/materias/create`, formData);
        }
    }
</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" src={post?.image}/>
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <Label name="title">Título</Label>
                <Input name="title" value={post?.title}/>
            </div>
            <div class="mb-8">
                <Label name="cover">Capa da matéria</Label>
                <Preview name="cover" previewHeight="max-h-[30rem]" src={post?.cover}/>
            </div>
            <div class="mb-8">
                <Label name="cover">Escreva sua matéria</Label>
                <Wysiwyg value={post?.content}/>
            </div>
        </div>
    </div>
    <div class="w-full xl:w-[85rem] ml-auto mb-10">
        <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
            <div class="mb-8">
                <Label name="first_category" styles="text-blue-skywave text-center font-bold italic">Primeira Tag</Label>
                <Select name="first_category" options={Tags} selected={post?.categories[0]?.category_name}/>
            </div>
            <div class="mb-8">
                <Label name="second_category" styles="text-blue-skywave text-center font-bold italic">Segunda Tag</Label>
                <Select name="second_category" options={Tags} selected={post?.categories[1]?.category_name}/>
            </div>
        </div>
        <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
            <div class="mb-8">
                <span class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Primeira fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] flex items-center mb-3">
                    <Label name="first_reference_name" styles="text-orange-amber">
                        Nome:
                    </Label>
                    <Input name="first_reference_name" value={post?.references[0]?.name}/>
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="first_reference_url" styles="text-orange-amber">
                        Link:
                    </Label>
                    <Input name="first_reference_url"  value={post?.references[0]?.url}/>
                </div>
            </div>
            <div class="mb-8">
                <span class="text-center text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Segunda fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] flex items-center mb-3">
                    <Label name="second_reference_name" styles="text-orange-amber">
                        Nome:
                    </Label>
                    <Input name="second_reference_name" value={post?.references[1]?.name}/>
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="second_reference_url" styles="text-orange-amber">
                        Link:
                    </Label>
                    <Input name="second_reference_url" value={post?.references[1]?.url}/>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        {#if post?.status === "published"}
            <Button type="submit" name="status" value="published" styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                Atualizar matéria
            </Button>
        {:else}
            <Button type="submit" name="status" value="sketch" styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl uppercase">
                Salvar como Rascunho
            </Button>
            <Button type="submit" name="status" value="revision" styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-orange-amber rounded-xl text-orange-amber text-xl uppercase">
                Mandar para revisão
            </Button>
            {#if user.permissions_keys?.includes("administrator")}
                <Button type="submit" name="status" value="published" styles="w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl uppercase">
                    Publicar
                </Button>
            {/if}
        {/if}
    </div>
</form>
