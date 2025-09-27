<script>
    let showSelected = null;
</script>

<form>
    <div class="flex flex-wrap justify-center gap-15 lg:gap-0 mt-10 mb-20">
        <button type="button" aria-label="teste" onclick={()=>showSelected = "primeiro"} class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
            <img
                src="https://media.discordapp.net/attachments/751993982246191126/1092580565074579516/IA.png?ex=68d868f1&is=68d71771&hm=86e15b47046b746cabb9fda6328ca27b71454684125ea423d478e46e3220e999&=&format=webp&quality=lossless"
                alt="logo"
                class={`w-60 transition duration-300 ease-in-out ${showSelected === "primeiro" ? "opacity-50 scale-90" : "opacity-100"}`} 
            />
        </button>
        <button type="button" aria-label="teste" onclick={()=>showSelected = "segundo"} class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
            <img
                src="https://media.discordapp.net/attachments/751993982246191126/1092580565074579516/IA.png?ex=68d868f1&is=68d71771&hm=86e15b47046b746cabb9fda6328ca27b71454684125ea423d478e46e3220e999&=&format=webp&quality=lossless"
                alt="logo"
                class={`w-60 transition duration-300 ease-in-out ${showSelected === "segundo" ? "opacity-50 scale-90" : "opacity-100"}`} 
            />
        </button>
        <button type="button" aria-label="teste" onclick={()=>showSelected = "terceiro"} class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
            <img
                src="https://media.discordapp.net/attachments/751993982246191126/1092580565074579516/IA.png?ex=68d868f1&is=68d71771&hm=86e15b47046b746cabb9fda6328ca27b71454684125ea423d478e46e3220e999&=&format=webp&quality=lossless"
                alt="logo"
                class={`w-60 transition duration-300 ease-in-out ${showSelected === "terceiro" ? "opacity-50 scale-90" : "opacity-100"}`} 
            />
        </button>
        <button type="button" aria-label="teste" onclick={()=>showSelected = "quarto"} class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
            <img
                src="https://media.discordapp.net/attachments/751993982246191126/1092580565074579516/IA.png?ex=68d868f1&is=68d71771&hm=86e15b47046b746cabb9fda6328ca27b71454684125ea423d478e46e3220e999&=&format=webp&quality=lossless"
                alt="logo"
                class={`w-60 transition duration-300 ease-in-out ${showSelected === "quarto" ? "opacity-50 scale-90" : "opacity-100"}`} 
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
</form>