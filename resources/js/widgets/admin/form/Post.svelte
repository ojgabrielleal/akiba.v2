<script>
    import { page } from "@inertiajs/svelte";
    import { Tabs } from "@/components/admin/tabs";
    import { Preview, Label, Input, Wysiwyg, Select } from "@/components/admin/form";

    import Tags from "@/data/admin/Tags";
    import TabsData from "@/data/admin/Tabs";

    const { post } = $page.props;

    $: if (post && post.status === "published") {
        TabsData.postsControls.splice(1, 1);
        TabsData.postsControls[0].label = "Transformar em Rascunho";
        TabsData.postsControls[1].label = "Atualizar Matéria Publicada";
    }
</script>

<form>
    <div class="grid grid-cols-1 lg:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-[var(--color-orange-amber)] font-bold italic text-lg uppercase font-noto-sans block mb-1">
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
    <div class="w-full lg:w-[85rem] ml-auto mb-10">
        <div class="gap-5 grid grid-cols-1 lg:grid-cols-2 lg:gap-10">
            <div class="mb-8">
                <Label name="first_tag" styles="text-[var(--color-blue-skywave)] text-center font-bold italic">Primeira Tag</Label>
                <Select options={Tags} selected={post?.categories[0]?.category_name}/>
            </div>
            <div class="mb-8">
                <Label name="second_tag" styles="text-[var(--color-blue-skywave)] text-center font-bold italic">Segunda Tag</Label>
                <Select options={Tags} selected={post?.categories[1]?.category_name}/>
            </div>
        </div>
        <div class="gap-5 grid grid-cols-1 lg:grid-cols-2 lg:gap-10">
            <div class="mb-8">
                <span class="text-center text-[var(--color-orange-amber)] font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Primeira fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center mb-3">
                    <Label name="first_font_search_name" styles="text-[var(--color-orange-amber)]">
                        Nome:
                    </Label>
                    <Input name="first_font_search_name" value={post?.references[0]?.name}/>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="first_font_search_url" styles="text-[var(--color-orange-amber)]">
                        Link:
                    </Label>
                    <Input name="first_font_search_url"  value={post?.references[0]?.url}/>
                </div>
            </div>
            <div class="mb-8">
                <span class="text-center text-[var(--color-orange-amber)] font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Segunda fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center mb-3">
                    <Label name="second_font_search_name" styles="text-[var(--color-orange-amber)]">
                        Nome:
                    </Label>
                    <Input name="second_font_search_name" value={post?.references[1]?.name}/>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="second_font_search_url" styles="text-[var(--color-orange-amber)]">
                        Link:
                    </Label>
                    <Input name="second_font_search_url" value={post?.references[1]?.url}/>
                </div>
            </div>
        </div>
    </div>
    <Tabs items={TabsData.postsControls} />
</form>
