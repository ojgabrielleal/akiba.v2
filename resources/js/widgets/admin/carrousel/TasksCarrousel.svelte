<script>
    export let title = null;

    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";

    import { scrollx } from "@/utils";

    $: ({ tasks } = $page.props);

    // Reference to component
    let container;

    // Submit user to finishing task
    function setTaskCompleted(id) {
        router.patch(`/painel/dashboard/tasks/${id}`);
    }
</script>

<Section {title}>
    <div
        class="scroll-x flex gap-5 overflow-x-auto flex-nowrap"
        bind:this={container}
        on:wheel={(e) => scrollx(e, container)}
        role="group"
    >
        {#if tasks.length > 0}
            {#each tasks as item}
                <div
                    class="w-100 h-50 lg:w-[40rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative"
                    style="background-color: {item.styles.bg};"
                >
                    <h1
                        class="uppercase font-noto-sans text-neutral-aurora italic font-bold text-2xl"
                    >
                        {item.title}
                    </h1>
                    <span
                        class="w-90 ont-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1"
                    >
                        {item.content}
                    </span>
                    <div
                        class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora"
                    >
                        <div
                            class="font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase"
                            style="background-color: {item.styles.bg_date
                                .title}; color: {item.styles.bg_date
                                .title_text_color}"
                        >
                            Data Limite
                        </div>
                        <div
                            class="font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest"
                            style="background-color: {item.styles.bg_date
                                .date}; color: {item.styles.bg_date
                                .date_text_color}"
                        >
                            {item.deadline}
                        </div>
                    </div>
                    {#if item.due_soon}
                        <button
                            class="font-noto-sans italic font-bold bg-red-crimson rounded-xl text-neutral-aurora uppercase absolute right-5 bottom-3 py-2 px-6 cursor-pointer"
                            on:click={() => setTaskCompleted(item.id)}
                        >
                            Solicitar Conclusão
                        </button>
                    {:else}
                        <button
                            class="bg-neutral-aurora absolute right-5 bottom-3 py-2 px-2 rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer"
                            on:click={() => setTaskCompleted(item.id)}
                        >
                            <img
                                src="/icons/default/verify.svg"
                                alt="verify icon"
                                class="w-5"
                            />
                        </button>
                    {/if}
                </div>
            {/each}
        {:else}
            <div
                class="w-100 h-50 lg:w-[40rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative bg-blue-cerulean opacity-50"
            >
                <h1
                    class="uppercase font-noto-sans text-neutral-aurora italic font-bold text-2xl"
                >
                    Animes com Aki-chan
                </h1>
                <span
                    class="w-90 ont-noto-sans text-sm text-neutral-aurora line-clamp-5 mt-1"
                >
                    Senpai~ no momento não tem task, então relaxa e vamos curtir
                    anime juntos~ kawaii ne~ (｡•́︿•̀｡) 🌸🍵 Pode ficar tranquilo,
                    eu vou avisar quando tiver algo pra fazer yo~ (⌒‿⌒)✨
                </span>
                <div
                    class="absolute top-5 right-5 rounded-xl shadow-lg w-[7rem] text-center overflow-hidden bg-neutral-aurora"
                >
                    <div
                        class="font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase bg-blue-indigo text-neutral-aurora"
                    >
                        Data Limite
                    </div>
                    <div
                        class="font-noto-sans italic font-extrabold text-2xl text-blue-indigo py-1 tracking-widest"
                    >
                        00/00
                    </div>
                </div>
            </div>
        {/if}
    </div>
</Section>
