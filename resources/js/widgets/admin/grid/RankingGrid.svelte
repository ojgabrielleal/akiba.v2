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

{#if ranking_musics.lenght > 0}
    <Section title="Akiba Ranking">
        <div class="flex flex-col gap-5">
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
        </div>
        <div class="flex justify-end mt-7">
            <button on:click={()=>setRanking()} class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic">
                Atualizar ranking
            </button>
        </div>
    </Section>
{/if}