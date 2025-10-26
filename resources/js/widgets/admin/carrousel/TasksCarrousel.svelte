<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import { scrollx } from "@/utils";

    $: ({ tasks } = $page.props);

    let container;

    function setTaskComplete(id) {
        router.put(`/painel/dashboard/set/complete/task/${id}`);
    }
</script>

<Section title="Minhas Tarefas">
    <div class="scroll-x flex gap-5 overflow-x-auto flex-nowrap" bind:this={container} on:wheel={(e) => scrollx(e, container)} role="group">
        {#if tasks.length > 0}
            {#each tasks as item}
                <article class="w-100 h-50 lg:w-[40rem] lg:h-43 shrink-0 rounded-lg p-4 relative" style="background-color: {item.styles.bg};">
                    <div class="uppercase font-noto-sans text-neutral-aurora italic font-bold text-2xl">
                        {item.title}
                    </div>
                    <div class="w-60 lg:w-90 font-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1">
                        {item.content}
                    </div>
                    <dl class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora">
                        <dt class="font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase" style="background-color: {item.styles.bg_date.title}; color: {item.styles.bg_date.title_text_color}">
                            Data Limite
                        </dt>
                        <dd class="font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest" style="background-color: {item.styles.bg_date.date}; color: {item.styles.bg_date.date_text_color}">
                            {item.deadline}
                        </dd>
                    </dl>
                    {#if item.due_soon}
                        <button
                            type="button"
                            class="font-noto-sans italic font-bold bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6 cursor-pointer"
                            on:click={() => setTaskComplete(item.id)}
                        >
                            Solicitar Conclusão
                        </button>
                    {:else}
                        <button
                            type="button"
                            aria-label="Concluir tarefa"
                            class="bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                            on:click={() => setTaskComplete(item.id)}
                        >
                            <img src="/svg/default/verify.svg" alt="" aria-hidden="true" class="w-5" loading="lazy"/>
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
