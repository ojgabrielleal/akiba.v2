<script>
    export let title;
    export let tasks;
    export let user;
        
    import { router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { scrollx, hasPermissions } from "@/utils";

    $: authorization = {
        canComplete: hasPermissions(user, 'task.complete')
    }

    function markTaskCompleted(task) {
        router.post(`/painel/dashboard/task/${task}/complete`);
    }
</script>

<Section {title}>
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" on:wheel={scrollx} role="group">
        {#if tasks.data.length > 0}
            {#each tasks.data as item}
                <article class={['w-100 h-50 lg:w-[40rem] bg-blue-skywave lg:h-43 shrink-0 rounded-lg p-4 relative',
                    {'bg-orange-amber': item.is_due_or_over},
                    {'bg-blue-skywave': !item.is_due_or_over}
                ]}>
                    <div class={['w-3/4 uppercase font-noto-sans italic font-bold text-2xl truncate', 
                        {'text-blue-midnight': item.is_due_or_over},
                        {'text-neutral-aurora': !item.is_due_or_over}
                    ]}>
                        {item.title}
                    </div>
                    <div class={['w-60 lg:w-90 font-noto-sans text-sm line-clamp-4 mt-1', 
                        {'text-blue-midnight': item.is_due_or_over},
                        {'text-neutral-aurora': !item.is_due_or_over}
                    ]}>
                        {item.content}
                    </div>
                    <dl class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora">
                        <dt class={['font-noto-sans italic font-black text-sm py-1 uppercase tracking-wide', 
                            {'bg-red-crimson': item.is_due_or_over},
                            {'bg-blue-midnight': !item.is_due_or_over},
                            {'text-blue-midnight': item.is_due_or_over},
                            {'text-neutral-aurora': !item.is_due_or_over}
                        ]}>
                            Data Limite
                        </dt>
                        <dd class={['font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest', 
                            {'bg-blue-midnight': item.is_due_or_over},
                            {'bg-neutral-aurora': !item.is_due_or_over},
                            {'text-orange-amber': item.is_due_or_over},
                            {'text-blue-midnight': !item.is_due_or_over}
                        ]}>
                            {item.deadline}
                        </dd>
                    </dl>
                    {#if authorization.canComplete}
                        <button type="button" aria-label="Concluir tarefa" on:click={() => markTaskCompleted(item.uuid)} class={['font-noto-sans italic font-bold cursor-pointer',
                            {'bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6': item.is_due_or_over},
                            {'bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center': !item.is_due_or_over}
                        ]}>
                            {#if item.is_due_or_over}
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
