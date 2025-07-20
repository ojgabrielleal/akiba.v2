<script>
    import { Tabs } from "@/components/admin/tabs";
    import {Preview, Label, Input, Wysiwyg, Select} from "@/components/admin/form";
    
    import Tags from "@/data/admin/Tags";
    import TabsData from "@/data/admin/Tabs";
</script>

<form>
    <div class="grid grid-cols-1 lg:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-[var(--color-orange-amber)] font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" />
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <Label name="title">Título</Label>
                <Input name="title" />
            </div>
            <div class="mb-8">
                <Label name="cover">Capa da matéria</Label>
                <Preview name="cover" previewHeight="max-h-[30rem]" />
            </div>
            <div class="mb-8">
                <Label name="cover">Escreva sua matéria</Label>
                <Wysiwyg />
            </div>
        </div>
    </div>
    <div class="w-[85rem] ml-auto mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="mb-8">
                <Label name="first_tag" styles="text-[var(--color-blue-skywave)] text-center font-bold italic">Primeira Tag</Label>
                <Select options={Tags} />
            </div>
            <div class="mb-8">
                <Label name="second_tag" styles="text-[var(--color-blue-skywave)] text-center font-bold italic">Segunda Tag</Label>
                <Select options={Tags} />
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="mb-8">
                <span class="text-center text-[var(--color-orange-amber)] font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Primeira fonte de pesquisa
                </span>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center mb-3">
                    <Label name="first_font_search_name" styles="text-[var(--color-orange-amber)]">
                        Nome:
                    </Label>
                    <Input name="first_font_search_name" />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="first_font_search_url" styles="text-[var(--color-orange-amber)]">
                        Link:
                    </Label>
                    <Input name="first_font_search_url" />
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
                    <Input name="second_font_search_name" />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-[5rem_1fr] flex items-center">
                    <Label name="second_font_search_url" styles="text-[var(--color-orange-amber)]">
                        Link:
                    </Label>
                    <Input name="second_font_search_url" />
                </div>
            </div>
        </div>
    </div>
    <Tabs items={TabsData.postsControls} />
</form>
