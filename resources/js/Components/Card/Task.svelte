<script>
    export let action;
    export let data = {};
    export let due = false;
    export let desactivate = false;

    import { Confirm, Danger } from "@/Components/Button"

    $: colors = due ? "bg-[var(--color-orange-amber)]" : "bg-[var(--color-blue-skywave)]";
</script>

{#if desactivate}
    <div class="bg-gray-600/20 w-[35rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative opacity-60">
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            Assistir Animes
        </h1>
        <p class="w-90 font-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            Senpai~ você tá de boas por agora (￣︶￣)v Nenhuma tarefa na lista, então aproveita 
            pra ver uns animes e colocar a cabeça no lugar, tá? Quando pintar algo, eu te aviso. Mata ne~ (＾▽＾)/
        </p>
        <div class="absolute top-5 right-5 bg-[var(--color-neutral-aurora)]/30 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden opacity-60">
            <div class="bg-[var(--color-blue-indigo)]/40 text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-blue-indigo)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                00/00
            </div>
        </div>
    </div>
{:else if due}
    <div class={`${colors} w-[40rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            {data.title}
        </h1>
        <p class="w-90 ont-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {data.content}
        </p>
        <div class="absolute top-5 right-5 bg-[var(--color-blue-indigo)] rounded-xl shadow-lg w-[7rem] text-center overflow-hidden">
            <div class="bg-[var(--color-red-crimson)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-neutral-aurora)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                {data.deadline}
            </div>
        </div>
        <Danger styles="absolute right-5 bottom-3" action={action}>
            Solicitar Conclusão
        </Danger>
    </div>
{:else}
    <div class={`${colors} w-[35rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            {data.title}
        </h1>
        <p class="w-90 ont-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            {data.content}
        </p>
        <div class="absolute top-5 right-5 bg-[var(--color-neutral-aurora)] rounded-xl shadow-lg w-[7rem] text-center overflow-hidden">
            <div class="bg-[var(--color-blue-indigo)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-blue-indigo)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                {data.deadline}
            </div>
        </div>
        <Confirm styles="absolute right-5 bottom-3" action={action}/>
    </div>
{/if}
