<script>
    export let item = null;
    export let action = null;
    export let styles = "w-100 h-50 lg:w-[29rem]";
    
    import { Button } from "@/components/admin/button";
</script>


{#if item}
    <div class={`${styles} bg-[var(--color-blue-skywave)] flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="font-noto-sans font-black italic uppercase text-[var(--color-neutral-aurora)] text-xl">
            {item.user.nickname}
        </h1>
        <span class="font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {item.content} 
        </span>
        <div class="flex gap-2 absolute bottom-3 left-4">
            {#if item.signatures.length > 0}
                {#each item.signatures as signature}
                    <img src={signature.user.avatar} alt={signature.user.nickname} class="w-9 h-9 rounded-full bg-[var(--color-neutral-aurora)]"/>
                {/each}
            {/if}
        </div>
        {#if item.enable_confirm}
            <Button styles="w-[2rem] h-[2rem] bg-[var(--color-neutral-aurora)] absolute bottom-3 right-4 rounded-md" action={action}>
                <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
            </Button>   
        {/if} 
    </div>
{:else}
    <div class="bg-gray-600/20 w-full h-50 flex-shrink-0 rounded-lg p-4 relative lg:w-2/5 xl:w-[28rem]">
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