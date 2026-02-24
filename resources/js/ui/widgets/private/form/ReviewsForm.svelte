<script>
    import { page, useForm, Link } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Section } from "@/ui/components/private/";
    import { Preview, Wysiwyg } from "@/ui/components/private";

    $: ({ user, review } = $page.props);

    let form = useForm({
        _method: "POST",
        image: null,
        title: null,
        sinopse: null,
        cover: null,
        review: {uuid: null, content: null},
    });

    $: if(review){
        $form._method = "PATCH",
        $form.image = review.data.image,
        $form.title = review.data.title,
        $form.sinopse = review.data.sinopse,
        $form.cover = review.data.cover,
        $form.review = { uuid: null, content: "" }
    }
    
    const submit = () => {
        let url = review ? `/painel/reviews/${review?.data.uuid}` : `/painel/reviews`       

        $form.post(url, {
            preserveState: review,
            onSuccess: () => {
                review ? null : $form.reset();
            },
        });
    }

    const reviews = () => {
        let verifyExistReview = review?.data.reviews.some((item) => item.author.uuid === user.uuid);

        if(verifyExistReview){
            let reviewExisting = review.data.reviews.find((item) => item.author.uuid === user.uuid);
            let reviewRest = review.data.reviews.filter((item) => item.author.uuid !== user.uuid);

            $form.review.uuid = reviewExisting.uuid;
            $form.review.content = reviewExisting.content;
            return [reviewExisting, ...reviewRest];
        }

        let reviewGhost = {
            uuid: null,
            content: 'Escreva o seu primeiro review',
            author: {
                uuid: user.uuid,
                name: user.name,
                nickname: user.nickname,
                avatar: user.avatar,
            }
        }

        $form.review.uuid = reviewGhost.uuid;
        $form.review.content = reviewGhost.content;
        return [reviewGhost, ...review?.data.reviews];
    }
</script>

<Meta meta={{ title: review?.data.title }} />
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
                        required={review ? false : true}
                    />   
                </div>
                <div>
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-2" for="content">
                        Escreva sobre o anime
                    </label>
                    {#if review && reviews()}
                        <div class="flex gap-2 mb-4">
                            {#each reviews() as item}
                                <div class="relative">
                                    <button 
                                        type="button" 
                                        on:click={()=>{
                                            $form.review.uuid = item.uuid
                                            $form.review.content = item.content; 
                                        }}
                                        class={["py-2 px-6 rounded-md uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer", 
                                            {'bg-orange-amber text-neutral-aurora' : item.uuid === $form.review.uuid},
                                            {'bg-neutral-aurora text-orange-amber' : item.uuid !== $form.review.uuid}
                                        ]}
                                    >
                                        {item.author.nickname}
                                    </button>
                                </div>
                            {/each}
                        </div>
                    {/if}
                    <Wysiwyg 
                        name="content" 
                        required
                        bind:value={$form.review.content} 
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                {$form.review.uuid ? 'Atualizar review' : 'Publicar review'} 
            </button>
        </div>
    </form>
</Section>