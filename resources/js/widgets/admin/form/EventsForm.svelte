<script>
    import { useForm, router, page } from "@inertiajs/svelte";
    import { Preview, Wysiwyg } from "@/components/admin";

    import Tags from "@/data/admin/Tags";

    $: ({ user, publication } = $page.props);

</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview 
                name="image" 
            />
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                    Nome do evento
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                    Capa do evento
                </label>
                <Preview 
                    name="cover" 
                    view="max-h-[30rem]" 
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                    Escreva sobre o evento
                </label>
                <Wysiwyg 
                    name="content" 
                />
            </div>
        </div>
    </div>
    <div class="w-full xl:w-[85rem] ml-auto mb-8">
        <div class="gap-5 grid grid-cols-1 xl:grid-cols-2 xl:gap-10">
            <div class="mb-8">
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="local">
                        Local:
                    </label>
                    <input
                        type="text"
                        id="local"
                        name="local"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                    />
                </div>
            </div>
            <div class="mb-8">
                <div class="grid grid-cols-1 xl:grid-cols-[5rem_1fr] items-center">
                    <label class="text-orange-amber font-light text-xl uppercase font-noto-sans block mb-1" for="datas">
                        Datas:
                    </label>
                    <input
                        type="text"
                        id="datas"
                        name="datas"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap">
        <button
            type="submit"
            aria-label="publicar"
            value="published"
            class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase"
        >
            Publicar
        </button>
    </div>
</form>
