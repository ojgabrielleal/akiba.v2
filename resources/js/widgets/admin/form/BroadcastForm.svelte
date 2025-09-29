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
            <button onclick={()=>showSelected = 1} key={1} type="button" aria-label="teste" class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                <img
                    src="https://media.discordapp.net/attachments/751993982246191126/1421897250828976258/IA.png?ex=68dab482&is=68d96302&hm=375b75577f44027ce16f906218b5b60f59758650947fe73cbc6fcfca92d998f6&=&format=webp&quality=lossless"
                    alt="logo"
                    class={`w-60 transition duration-300 ease-in-out ${showSelected === 1 ? "opacity-50 scale-90" : "opacity-100"}`} 
                />
            </button>
            <button onclick={()=>showSelected = 2} key={2} type="button" aria-label="teste" class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                <img
                    src="https://i.ibb.co/v6Zfr9xp/PE.png"
                    alt="logo"
                    class={`w-60 transition duration-300 ease-in-out ${showSelected === 2 ? "opacity-50 scale-90" : "opacity-100"}`} 
                />
            </button>
            <button onclick={()=>showSelected = 3} key={3} type="button" aria-label="teste" class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                <img
                    src="https://i.ibb.co/spcHRdH9/HNY.png"
                    alt="logo"
                    class={`w-60 transition duration-300 ease-in-out ${showSelected === 3 ? "opacity-50 scale-90" : "opacity-100"}`} 
                />
            </button>
            <button onclick={()=>showSelected = 4} key={4} type="button" aria-label="teste" class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                <img
                    src="https://i.ibb.co/1YwZM2FS/AAO.png"
                    alt="logo"
                    class={`w-60 transition duration-300 ease-in-out ${showSelected === 4 ? "opacity-50 scale-90" : "opacity-100"}`} 
                />
            </button>
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
                    <button onclick={()=>iconSelected = icon.url} type="button" aria-label="teste" class={`cursor-pointer w-[9.55rem] h-[3rem] flex justify-end items-end rounded-lg bg-neutral-aurora transition duration-300 ease-in-out ${iconSelected === icon.url ? "opacity-50 scale-90" : "opacity-100"} `}>
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