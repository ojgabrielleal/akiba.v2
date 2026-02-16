<script>
    export let title;
        
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx } from "@/utils";

    $: ({ tasks } = $page.props);

    function markTaskCompleted(task) {
        router.post(`/painel/dashboard/task/${task}/complete`);
    }
</script>

{#if tasks}
    <Section {title}>
        <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
            {#if tasks.data.length > 0}
                {#each tasks.data as item}
                    <article class='{item.ui.background} w-100 h-50 lg:w-[40rem] bg-blue-skywave lg:h-43 shrink-0 rounded-lg p-4 relative'>
                        <div class='{item.ui.title} w-3/4 uppercase font-noto-sans italic font-bold text-2xl truncate'>
                            {item.title}
                        </div>
                        <div class='{item.ui.content} w-60 lg:w-90 font-noto-sans text-sm line-clamp-4 mt-1'>
                            {item.content}
                        </div>
                        <dl class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora">
                            <dt class='{item.ui.deadline.header.background} {item.ui.deadline.header.title} font-noto-sans italic font-black text-sm py-1 uppercase tracking-wide'>
                                Data Limite
                            </dt>
                            <dd class='{item.ui.deadline.body.background} {item.ui.deadline.body.text} font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest'>
                                {item.deadline_formated}
                            </dd>
                        </dl>
                        {#if item.actions.can_complete}
                            <button 
                                type="button" 
                                class='{item.ui.confirmation.default} font-noto-sans italic font-bold cursor-pointer'
                                aria-label="Concluir tarefa" 
                                on:click={() => markTaskCompleted(item.uuid)}
                            >
                                {#if item.is_due}
                                    Solicitar conclusão
                                {:else}
                                    <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                                {/if}
                            </button>
                        {/if}
                    </article>
                {/each}
            {:else}
                <article class="w-100 h-50 lg:w-[40rem] lg:h-43 shrink-0 rounded-lg p-4 relative bg-blue-cerulean opacity-50">
                    <div class="uppercase font-noto-sans text-neutral-aurora italic font-bold text-2xl">
                        Morgar no sofá
                    </div>
                    <div class="w-60 lg:w-90 font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                        Nenhuma tarefa no radar… surpreendente, né? Parece que os administradores da Akiba decidiram tirar uma pausa “infinita”. 
                        Fica tranquilo que quando eles voltarem e inventarem algo eu te aviso... Tentarei.
                    </div>
                    <dl class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora">
                        <dt class="font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase bg-blue-indigo text-neutral-aurora">
                            Data Limite
                        </dt>
                        <dd class="font-noto-sans italic font-extrabold text-2xl text-blue-indigo py-1 tracking-widest">
                            00/00
                        </dd>
                    </dl>
                </article>
            {/if}
        </div>
    </Section>
{/if}