<script>
    export let title = null;
    export let tasks = null;
        
    import { Section, CanRender } from "@/ui/components/private/";
    import { markTaskCompleted } from "@/lib/requests";
    import { scrollx, date } from "@/utils";
</script>

<Section title={title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
        {#if tasks.length > 0}
            {#each tasks as item}
                {@const isDueOrOverdue = item.is_over || item.is_due}
                <article class={['w-100 h-50 lg:w-[40rem] bg-blue-skywave lg:h-43 shrink-0 rounded-lg p-4 relative',
                    {'bg-orange-amber': isDueOrOverdue},
                    {'bg-blue-skywave': !isDueOrOverdue}
                ]}>
                    <div class={['w-3/4 uppercase font-noto-sans italic font-bold text-2xl truncate', 
                        {'text-blue-midnight': isDueOrOverdue},
                        {'text-neutral-aurora': !isDueOrOverdue}
                    ]}>
                        {item.title}
                    </div>
                    <div class={['w-60 lg:w-90 font-noto-sans text-sm line-clamp-4 mt-1', 
                        {'text-blue-midnight': isDueOrOverdue},
                        {'text-neutral-aurora': !isDueOrOverdue}
                    ]}>
                        {item.content}
                    </div>
                    <dl class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora">
                        <dt class={['font-noto-sans italic font-black text-sm py-1 uppercase tracking-wide', 
                            {'bg-red-crimson': isDueOrOverdue},
                            {'bg-blue-midnight': !isDueOrOverdue},
                            {'text-blue-midnight': isDueOrOverdue},
                            {'text-neutral-aurora': !isDueOrOverdue}
                        ]}>
                            Data Limite
                        </dt>
                        <dd class={['font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest', 
                            {'bg-blue-midnight': isDueOrOverdue},
                            {'bg-neutral-aurora': !isDueOrOverdue},
                            {'text-orange-amber': isDueOrOverdue},
                            {'text-blue-midnight': !isDueOrOverdue}
                        ]}>
                            {item.deadline}
                        </dd>
                    </dl>
                    <CanRender permission="task.complete">
                        <button type="button" aria-label="Concluir tarefa" on:click={() => markTaskCompleted(item.id)} class={['font-noto-sans italic font-bold cursor-pointer',
                            {'bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6': isDueOrOverdue},
                            {'bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center': !isDueOrOverdue}
                        ]}>
                            {#if isDueOrOverdue}
                                Solicitar conclusão
                            {:else}
                                <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
                            {/if}
                        </button>
                    </CanRender>
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
