<script>
    export let title = null;
    import { Section } from "@/layouts/admin/";

    import Shows from "@/data/admin/Shows.json";

    let showSelected = null;
    let iconSelected = null;
</script>

<Section title={title}>
    <form>
        <div class="flex flex-wrap justify-center gap-15 lg:gap-x-0 lg:gap-y-15 0 mt-10 mb-20">
            {#each Array(4) as _, i}            
                <button onclick={()=>showSelected = i} key={i} type="button" aria-label="teste" class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                    <img
                        src="https://media.discordapp.net/attachments/751993982246191126/1092580565074579516/IA.png?ex=68d868f1&is=68d71771&hm=86e15b47046b746cabb9fda6328ca27b71454684125ea423d478e46e3220e999&=&format=webp&quality=lossless"
                        alt="logo"
                        class={`w-60 transition duration-300 ease-in-out ${showSelected === i ? "opacity-50 scale-90" : "opacity-100"}`} 
                    />
                </button>
            {/each}
        </div>
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="phrase">
                Qual é a frase para esse programa?
            </label>
            <input
                type="text"
                id="phrase"
                name="phrase"
                class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
            />
        </div>
        <div class="mb-15">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block" for="span">
                Escolha um icone
            </span>
            <div class="flex flex-wrap justify-center lg:justify-start gap-30 lg:gap-y-30 lg:gap-x-5 mt-[7rem]">
                {#each Shows.icons as icon}
                    <button onclick={()=>iconSelected = icon.url} type="button" aria-label="teste" class={`cursor-pointer w-[9.55rem] h-[3rem] flex justify-center items-end rounded-lg bg-neutral-aurora transition duration-300 ease-in-out ${iconSelected === icon.url ? "opacity-50 scale-90" : "opacity-100"} `}>
                        <img 
                            src={icon.url}
                            alt="avatar" 
                            class="w-[8.5rem] aspect-square"
                        />
                    </button>
                {/each}
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" aria-label="iniciar programa" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                Entrar ao vivo
            </button>
        </div>
    </form>
</Section>