<script>
    import { page } from "@inertiajs/svelte";
    import { Preview, Wysiwyg } from "@/components/admin";

    $:({ user, publication } = $page.props);
    
    $:if(publication){
        console.log(publication);
    }
    
    $: authorSelected = user.nickname
</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" value={publication?.image}/>
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
                    value={publication?.title}
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="sinopse">
                    Sinopse do anime
                </label>
                <Wysiwyg height="15rem" name="sinopse" value={publication?.sinopse}/>
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                    Capa do review
                </label>
                <Preview name="cover"  value={publication?.cover}/>
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                    Escreva o review
                </label>
                <div class="flex mb-3 mt-2 gap-2">
                    <div class="relative inline-block mb-2">
                        <button aria-label="teste" class="bg-neutral-aurora py-2 px-6 rounded-md text-orange-amber uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer relative">
                            teste
                        </button>
                        <span class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px] border-t-neutral-aurora">
                        </span>
                    </div>
                    <div class="relative inline-block mb-2">
                        <button aria-label="teste" class="bg-neutral-aurora py-2 px-6 rounded-md text-orange-amber uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer relative">
                            teste
                        </button>
                    </div>
                </div>
                <Wysiwyg name="content"/>
            </div>  
        </div>
    </div>
</form>
