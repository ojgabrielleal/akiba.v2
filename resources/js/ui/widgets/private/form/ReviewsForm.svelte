<script>
    export let review;
    export let user;

    import { onMount } from "svelte";
    import { useForm, Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Preview, Wysiwyg } from "@/ui/components/private";

    $: selected = review?.reviews.find(
        (item) => item.user.id === user.id,
    );

    let form = useForm({
        _method: null,
        content_id: null,
        image: null,
        title: null,
        sinopse: null,
        cover: null,
        content: null,
    });

    onMount(()=>{
        if(review){
            $form._method = "patch",
            $form.image = review.image,
            $form.title = review.title,
            $form.sinopse = review.sinopse,
            $form.cover = review.cover,
            $form.content = selected.content
        }
    })

    function onSubmit() {
        let url = review ? `/painel/reviews/${review.id}` : `/painel/reviews`       

        $form.post(url, {
            preserveState: review,
            onSuccess: () => {
                review ? null : $form.reset();
            },
        });
    }
</script>

<Section title={review ? "Editar review" : "Criar review"}>
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
    <form on:submit|preventDefault={onSubmit} class="mt-10 xl:mt-15">
        <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-1">
                    Imagem em destaque
                </div>
                <Preview 
                    name="image" 
                    src={$form.image} 
                    oninput={event => $form.image = event.target.files[0]} 
                    required={review ? false : true}
                />        
            </div>
            <div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                        Nome do anime
                    </label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={$form.title}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="sinopse">
                        Sinopse do anime
                    </label>
                    <Wysiwyg
                        height="15rem"
                        name="sinopse"
                        bind:value={$form.sinopse}
                        required
                    />
                </div>
                <div class="mb-8">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                        Capa do anime
                    </label>
                    <Preview 
                        name="cover" 
                        viewobject="object-cover"
                        src={$form.cover} 
                        oninput={event => $form.cover = event.target.files[0]} 
                        required
                    />   
                </div>
                <div>
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                        Escreva sobre o anime
                    </label>
                        <div class="flex mb-3 mt-2 gap-2">
                            {#each review && review.reviews as item}
                                <div class="relative inline-block mb-2">
                                    <button type="button" class="py-2 px-6 rounded-md uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer relative {item.user.id === authorSelected ? 'bg-neutral-aurora text-blue-ocean' : 'bg-blue-ocean text-neutral-aurora'}" on:click={() => (authorSelected = item.user.id)}>
                                        {item.user.nickname}
                                    </button>
                                    {#if item.user.id === authorSelected}
                                        <span class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px] border-t-neutral-aurora">
                                        </span>
                                    {/if}
                                </div>
                            {/each}
                        </div>
                    <Wysiwyg name="content" bind:value={$form.content} required={true}/>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                {selected?.content ? 'Atualizar review' : 'Publicar review'}
            </button>
        </div>
    </form>
</Section>