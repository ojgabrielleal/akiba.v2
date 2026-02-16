<script>
    export let review;
    export let user;

    import { useForm, Link } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { Preview, Wysiwyg } from "@/ui/components/private";

    let form = useForm({
        _method: null,
        image: null,
        title: null,
        sinopse: null,
        cover: null,
        content: { id: null, content: null},
    });

    $: if(review){
        $form._method = "patch",
        $form.image = review.image,
        $form.title = review.title,
        $form.sinopse = review.sinopse,
        $form.cover = review.cover
    }
    
    const submit = () => {
        let url = review ? `/painel/reviews/${review.id}` : `/painel/reviews`       

        $form.post(url, {
            preserveState: review,
            onSuccess: () => {
                review ? null : $form.reset();
            },
        });
    }

    const list = () => {
        const hasReview = review.reviews.some(item => item.author.id === user.id);
        
        if(hasReview){
            const userReview = review.reviews.find(item => item.author.id === user.id);
            const otherReviews = review.reviews.filter(item => item.author.id !== user.id);
            const mesh = [userReview, ...otherReviews];
            
            $form.content = userReview;
            return mesh;
        }

        let reviewsUnstructured = [{
            author: user, 
            content: "",
        }, ...review.reviews];

        $form.content = reviewsUnstructured[0];
        return reviewsUnstructured;
    };
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
    <form on:submit|preventDefault={submit} class="mt-10 xl:mt-15">
        <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans mb-2">
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
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2" for="title">
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
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2" for="sinopse">
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
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2" for="cover">
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
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2" for="content">
                        Escreva sobre o anime
                    </label>
                    {#if review}
                        <div class="flex gap-2 mb-6">
                            {#each list() as item}
                                <div class="relative">
                                    <button 
                                        type="button" 
                                        class={["py-2 px-6 rounded-md uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer",
                                            {'bg-orange-amber text-neutral-aurora': item.author.slug === $form.content.author.slug},
                                            {'bg-neutral-aurora': item.author.slug !== $form.content.author.slug},
                                        ]}
                                        on:click={() => $form.content = item} 
                                    >
                                        {item.author.nickname}
                                    </button>
                                    <span class={["absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px]",
                                        {'border-t-orange-amber': item.author.slug === $form.content.author.slug},
                                        {'border-t-neutral-aurora': item.author.slug !== $form.content.author.slug}
                                    ]}>
                                    </span>
                                </div>
                            {/each}
                        </div>
                    {/if}
                    <Wysiwyg 
                        name="content" 
                        bind:value={$form.content.content} 
                        required
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                Salvar review
            </button>
        </div>
    </form>
</Section>