<script>
    export let item = null;
    export let styles = "w-full h-[14rem] lg:w-[18.2rem]";

    import { Link } from "@inertiajs/svelte";
    import { Button } from "@/components/admin/button";
</script>

{#if item}
    <div class={`${styles} bg-blue-skywave flex-shrink-0 rounded-lg p-4 relative`}>
        <span class="font-noto-sans text-lg text-neutral-aurora line-clamp-5 uppercase">
            {item.title}
        </span>
        <div class="flex justify-end gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
            <div class="flex gap-3">
                <Link href={`https://akiba.com.br/reviews/${item.slug}`}>
                    <Button styles="p-0">
                        <img src="/icons/eye.svg" alt="eye icon" class="w-5 filter-neutral-aurora"/>
                    </Button>
                </Link>
                <Link href={`/painel/reviews/${item.slug}`}>
                    <Button styles="p-0">
                        <img src="/icons/edit.svg" alt="edit icon" class="w-4 filter-neutral-aurora"/>
                    </Button>
                </Link>
            </div>
        </div>
    </div>
{:else}
    <div class="bg-gray-600/20 w-full h-[14rem] flex-shrink-0 rounded-lg p-4 opacity-60 relative lg:w-[18.2rem]">
        <span class="font-noto-sans text-lg text-neutral-aurora line-clamp-5">
            Kyaaa~! Esse review não é desse anime!... é sério isso!? <br/>(⊙﹏⊙✿)💖  
        </span>
         <div class="absolute bottom-3 left-4 w-[calc(100%-2rem)]">
            <span class="font-noto-sans font-bold italic uppercase text-lg text-neutral-aurora">
                Aki-chan
            </span>
        </div>
    </div>
{/if}