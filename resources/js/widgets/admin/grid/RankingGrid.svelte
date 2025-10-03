<script>
    export let title = null;

    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { Preview } from "@/components/admin";

    $: ({ ranking_musics } = $page.props);

    $: if(ranking_musics){
        console.log(ranking_musics)
    }

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

<Section {title}>
    <div class="flex flex-col gap-5">
        {#each ranking_musics as item, index}
            <div class="flex flex-wrap lg:flex-nowrap items-center gap-5">
                <div class="flex items-center gap-5">
                    <Preview 
                        size="w-[6rem] h-[6rem]" 
                        view="w-[6rem] h-[6rem]" 
                        src={item.image_ranking} 
                        oninput={(event) => (updateImageRanking(event, item.id))}
                    />
                    <span class="text-neutral-aurora text-6xl font-noto-sans font-bold uppercase italic">
                        #{index + 1}
                    </span>
                </div>
                <span class="text-neutral-aurora font-noto-sans uppercase">
                    {item.music} - {item.type} - {item.production} - {item.artist}
                </span>
            </div>
        {/each} 
    </div>
    <div class="flex justify-end mt-7">
        <button onclick={()=>setRanking()} class="cursor-pointer bg-blue-skywave px-4 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold uppercase italic">
            Atualizar ranking
        </button>
    </div>
</Section>
