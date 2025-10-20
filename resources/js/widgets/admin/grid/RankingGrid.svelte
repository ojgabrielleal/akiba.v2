<script>
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Preview } from "@/components/admin";

    $: ({ ranking_musics } = $page.props);

    function updateImageRanking(event, id){
        const formData = new FormData();
        formData.append('image_ranking', event.target.files[0]);

        router.post(`/painel/radio/update/ranking/image/${id}`, formData, {
            forceFormData: true
        });
    }

    function setRanking(){
        router.post('/painel/radio/create/ranking');
    }
</script>

<Section title="Akiba Ranking">
    <div class="flex flex-col gap-5">
        {#if ranking_musics.length >= 3}
            {#each ranking_musics as item, index}
                <article class="flex flex-wrap lg:flex-nowrap items-center gap-5">
                    <div class="flex items-center gap-5">
                        <Preview size="w-[6rem] h-[6rem]" view="w-[6rem] h-[6rem]" src={item.image_ranking} oninput={(event) => (updateImageRanking(event, item.id))}/>
                        <strong class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic">
                            #{index + 1}
                        </strong>
                    </div>
                    <div class="text-neutral-aurora font-noto-sans uppercase">
                        {item.music} - {item.type} - {item.production} - {item.artist}
                    </div>
                </article>
            {/each} 
        {:else}
            <article class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none">
                <Preview size="w-[6rem] h-[6rem]" view="w-[6rem] h-[6rem]"/>
                <div class="flex items-center gap-5">
                    <strong class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic">
                        #1
                    </strong>
                </div>
                <div class="text-neutral-aurora font-noto-sans uppercase">
                    Guren no Yumiya - OP - Attack on Titan - Linked Horizon
                </div>
            </article>
            <article class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none">
                <Preview size="w-[6rem] h-[6rem]" view="w-[6rem] h-[6rem]"/>
                <div class="flex items-center gap-5">
                    <strong class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic">
                        #2
                    </strong>
                </div>
                <div class="text-neutral-aurora font-noto-sans uppercase">
                    Blue Bird - OP - Naruto Shippuden - Ikimono Gakari
                </div>
            </article>
            <article class="flex flex-wrap lg:flex-nowrap items-center gap-5 opacity-50 pointer-events-none">
                <Preview size="w-[6rem] h-[6rem]" view="w-[6rem] h-[6rem]"/>
                <div class="flex items-center gap-5">
                    <strong class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic">
                        #3
                    </strong>
                </div>
                <div class="text-neutral-aurora font-noto-sans uppercase">
                    My Dearest - OP - Guilty Crown - Supercell
                </div>
            </article>
        {/if}
        </div>
        <div class="flex justify-end mt-7" >
            <button on:click={()=>setRanking()} disabled={ranking_musics.length < 3} class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic disabled:opacity-50 disabled:pointer-events-none">
                Atualizar ranking
            </button>
        </div>
    </Section>