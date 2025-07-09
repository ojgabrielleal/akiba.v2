<script>
    export let action;
    export let data = {};
    export let desactivate = false;
    
    import { Confirm } from "@/Components/Button";
</script>

{#if !desactivate}
    <div class="bg-[var(--color-blue-skywave)] w-[29rem] h-50 flex-shrink-0 rounded-lg p-4 relative">
        <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl">
            {data.user.nickname}
        </h1>
        <span class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {data.content} 
        </span>
        <div class="flex gap-2 absolute bottom-3 left-4">
            {#if data.signatures.length > 0}
                {#each data.signatures.slice(0, 4) as signature}
                    <img src={signature.user.avatar} alt={signature.user.nickname} class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
                {/each}
            {/if}
        </div>
        <Confirm action={action} styles="absolute bottom-3 right-4"/>    
    </div>
{:else}
    <div class="bg-gray-600/20 w-[29rem] h-50 flex-shrink-0 rounded-lg p-4 relative">
        <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl opacity-70">
            Aki-chan
        </h1>
        <span class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1 opacity-70">
            Senpai~! ✨(≧◡≦)~ tô dando uma olhadinha aqui, e... não tem nenhum aviso novo por enquanto, 
            gomen ne~ (；・∀・)💦 Assim que aparecer alguma coisinha, eu te aviso rapidinho, tá bom? 
            Ganbatte~! 💌(๑˃̵ᴗ˂̵)و♡
        </span>
    </div>
{/if}