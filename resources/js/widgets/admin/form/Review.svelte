<script>
    import { router, page } from "@inertiajs/svelte";
    import { Preview, Label, Input, Wysiwyg, Select } from "@/components/admin/form";
    import { Button } from "@/components/admin/button";

    import Tags from "@/data/admin/Tags";

    $:({ user, review } = $page.props);

    $:if(review){
        console.log(review)
    }

    function setUserGet(userId){
        
    }
    
</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" value={review?.image}/>
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <Label name="title">Título</Label>
                <Input name="title" value={review?.title}/>
            </div>
            <div class="mb-8">
                <Label name="review">Sinopse do anime</Label>
                <Wysiwyg height="15rem" name="review" value={review?.sinopse}/>
            </div>
            <div class="mb-8">
                <Label name="cover">Capa do review</Label>
                <Preview name="cover"  value={review?.cover}/>
            </div>
            <div class="mb-8">
                <Label name="content">Escreva o review</Label>
                <div class="flex mb-3 mt-2">
                    {#each review?.authors as author}
                        <Button styles="bg-neutral-aurora py-2 px-6 rounded-sm text-orange-amber uppercase">
                            {author.nickname}
                        </Button>
                    {/each}
                </div>
                <Wysiwyg name="content"/>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
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
    </div>
</form>
