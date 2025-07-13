<script>
    export let item = null;
    export let action = null;
    export let due = false;
    export let styles = "w-100 h-50 lg:w-[40rem] lg:h-43";
    export let background = "bg-[var(--color-blue-skywave)]";

    import { Button } from "@/components/admin/button"

    $: bg = due ? "bg-[var(--color-orange-amber)]" : background;
    $: calendar = due ? "bg-[var(--color-red-crimson)]" : "bg-[var(--color-blue-indigo)]";
</script>

{#if item}
    <div class={`${bg} ${styles} flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            {item.title}
        </h1>
        <span class="w-90 ont-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {item.content}
        </span>
        <div class="absolute top-5 right-5 bg-[var(--color-blue-indigo)] rounded-xl shadow-lg w-[7rem] text-center overflow-hidden">
            <div class={`${calendar} text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase`}>
                item Limite
            </div>
            <div class="text-[var(--color-neutral-aurora)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                {item.deadline}
            </div>
        </div>
        {#if due}
            <Button styles="bg-[var(--color-red-crimson)] py-2 px-6 rounded-xl font-noto-sans font-bold text-[var(--color-neutral-aurora)] italic uppercase absolute right-5 bottom-3" action={action}>
                Solicitar Conclusão
            </Button>
        {:else}
            <Button styles="absolute right-5 bottom-3" action={action}>
                <img src="/icons/verify.svg" alt="verify icon" class="w-5"/>
            </Button>
        {/if}
    </div>
{:else}
    <div class="bg-gray-600/20 w-full h-43 flex-shrink-0 rounded-lg p-4 relative opacity-60 lg:w-[35rem]">
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            Assistir Animes
        </h1>
        <span class="w-full font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1 lg:w-90">
            Senpai~ você tá de boas por agora (；・∀・)💦 Nenhuma tarefa na lista 📝, então aproveita 
            pra ver uns animes 🎌📺 e colocar a cabeça no lugar 🍵. Quando pintar algo, eu te 
            aviso rapidinho 💌💨. Mata ne~ (＾▽＾)/🌸
        </span>
        <div class="hidden absolute top-5 right-5 bg-[var(--color-neutral-aurora)]/30 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden opacity-60 lg:block">
            <div class="bg-[var(--color-blue-indigo)]/40 text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-blue-indigo)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                00/00
            </div>
        </div>
    </div>
{/if}