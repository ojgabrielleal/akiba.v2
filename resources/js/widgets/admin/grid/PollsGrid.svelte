<script>
    import { router, page } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";    
    import { Offcanvas } from "@/components/admin";
    import { PollsForm } from "@/widgets/admin/form"

    $: ({ screenPermissions, polls } = $page.props);

    $: votedPolls = JSON.parse(localStorage.getItem('akiba-voted') || '[]');

    function voteQuestion(event, item){
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const option = formData.get('option');

        router.post(`/painel/medias/create/vote/${option}`, {}, {
            onSuccess: () => {
                votedPolls.push(item.question);
                localStorage.setItem('akiba-voted', JSON.stringify(votedPolls));
                votedPolls = votedPolls;
            }
        });
    }

    function deactivatePoll(id){
        router.delete(`/painel/medias/deactivate/poll/${id}`);
    }

</script>

<Section title="Enquetes">
    {#if screenPermissions.create_poll}
        <div class="flex justify-center">
            <Offcanvas>
                <div class="cursor-pointer text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber" slot="action" >
                    Criar enquete
                </div>
                <div slot="title">
                    Cadastrar enquete
                </div>
                <div slot="content" let:close>
                    <PollsForm close={close}/>
                </div>
            </Offcanvas>
        </div>
    {/if}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-10">
        {#if polls.length > 0}
            {#each polls as item}
                {@const alreadyVoted = votedPolls.includes(item.question)}
                <form on:submit|preventDefault={() => voteQuestion(event, item)} class="bg-blue-skywave p-5 rounded-md">
                    <div class="text-neutral-aurora text-xl text-start font-noto-sans font-bold mb-7">
                        {item.question}
                    </div>
                    <div class="flex flex-col gap-3 mb-7">
                        {#each item.options as subitem}
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center cursor-pointer" for={subitem.id}>
                                    <input 
                                        id={subitem.id} 
                                        name="option" 
                                        type="radio" 
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                                        value={subitem.id} 
                                        disabled={alreadyVoted}
                                    >
                                    <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                                </label>
                                <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for={subitem.id}>
                                    <div>
                                        {subitem.option}
                                    </div>
                                    <div>
                                        {subitem.votes}
                                    </div>
                                </label>
                            </div>
                        {/each}
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="cursor-pointer text-neutral-aurora text-md font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber disabled:opacity-50" disabled={alreadyVoted}>
                            Votar
                        </button>
                        <div class="flex gap-3">
                            {#if item.actions.edit}
                                <Offcanvas>
                                    <div aria-label="Editar" class="cursor-pointer" slot="action" >
                                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                    </div>
                                    <div slot="title">
                                        Atualizar enquete
                                    </div>
                                    <div slot="content" let:close>
                                        <PollsForm pollId={item.id} close={close}/>
                                    </div>
                                </Offcanvas>
                            {/if}
                            {#if item.actions.deactivate}
                                <button on:click={()=>deactivatePoll(item.id)} type="button" class="cursor-pointer" aria-label="Desativar">
                                    <img src="/svg/default/trash.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora" loading="lazy"/>
                                </button>
                            {/if}
                        </div>
                    </div>
                </form>
            {/each}
        {:else}
            <article class="bg-blue-cerulean opacity-50 p-5 rounded-md pointer-events-none">
                <div class="text-neutral-aurora text-xl text-start font-noto-sans font-bold mb-7">
                    Quem é o mais preguiçoso do time da Akiba até agora?
                </div>
                <dl class="flex flex-col gap-3 mb-7">
                    <dt class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="option">
                            <input 
                                id="option"
                                name="option" 
                                type="radio" 
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                            >
                            <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                        </label>
                        <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                            Neko Kirame
                        </label>
                    </dt>
                    <dd class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="option">
                            <input 
                                id="option"
                                name="option" 
                                type="radio" 
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                            >
                            <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                        </label>
                        <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                            Takashi
                        </label>
                    </dd>
                    <dt class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="option">
                            <input 
                                id="option"
                                name="option" 
                                type="radio" 
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                            >
                            <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                        </label>
                        <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                            NHK
                        </label>
                    </dt>
                    <dd class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="option">
                            <input 
                                id="option"
                                name="option" 
                                type="radio" 
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-full bg-neutral-aurora" 
                            >
                            <div class="absolute bg-blue-skywave w-2/4 h-2/4 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                        </label>
                        <label class="w-full ml-2 flex justify-between text-neutral-aurora text-md font-noto-sans cursor-pointer" for="option">
                            Suzuh
                        </label>
                    </dd>
                </dl>
                <div class="flex justify-between">
                    <button type="submit" class="cursor-pointer text-neutral-aurora text-md font-noto-sans font-bold uppercase italic rounded-sm py-1 px-3 bg-orange-amber">
                        Votar
                    </button>
                </div>
            </article>
        {/if}
    </div>
</Section>