<script>
    import { Section } from "@/layouts/admin/";
    import { Preview, Wysiwyg } from "@/components/admin";
</script>

<Section title="Adicionar Podcast">
    <form class="mt-10">
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr] gap-8 mb-8">
            <div>
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Capa do podcast
                </div>
                <Preview  />
            </div>
            <div class="flex flex-col gap-8">
                <div class="grid grid-cols-1 xl:grid-cols-[9rem_9rem_1fr] gap-5">
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="season">
                            Temporada
                        </label>  
                        <input
                            id="season"
                            type="text"
                            name="season"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        />                  
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="episode">
                            Episódio
                        </label>  
                        <input
                            id="episode"
                            type="text"
                            name="episode"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        />                  
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                            Título do episódio
                        </label>  
                        <input
                            id="title"
                            type="text"
                            name="title"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        />                  
                    </div>
                </div>
                <div>
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="summary">
                        Resumo do episódio
                    </label>  
                    <Wysiwyg
                        height="13rem"
                        name="summary"
                    />
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="description">
                    Escreva sobre o episódio
                </label> 
                <Wysiwyg
                    height="25rem"
                    name="description"
                />
            </div>
            <div>
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="audio">
                    URL Embeded do episódio
                </label> 
                <input
                    id="audio"
                    type="text"
                    name="audio"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                /> 
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center lg:flex-nowrap mt-10">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
                Publicar
            </button>
        </div>
    </form>
</Section>
