<script>
    import { page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";   
    
    $: ({ users } = $page.props);

    $: if(users){
        console.log(users)
    }
</script>

<div class="flex justify-center gap-5 mb-5">
    <button class="text-blue-skywave text-xl font-noto-sans font-bold italic uppercase">
        Cadastrar membro
    </button>
    <span class="border-l border-neutral-aurora/30"></span>
    <button class="text-blue-skywave text-xl font-noto-sans font-bold italic uppercase">
        Agendar Atividade
    </button>
</div>
<Section title="Membros cadastrados">
    <div class="mt-18 grid grid-cols-1 lg:grid-cols-4 gap-15 lg:gap-x-5 lg:gap-y-18">
        {#each users as item}
            <article class="h-35 px-3 py-1 bg-blue-skywave rounded-sm relative">
                <dl>
                    <dt class="text-neutral-aurora text-xl lg:text-2xl font-noto-sans font-bold italic uppercase">
                        {item.nickname}
                    </dt>
                    <dd class="text-neutral-aurora text-xs font-noto-sans font-semibold italic uppercase">
                        {item.name}
                    </dd>
                </dl>
                <img class="w-35 absolute right-0 bottom-0" src={item.avatar} alt="" aria-hidden="true"/>
                <div class="w-full flex justify-between items-end px-3 absolute left-0 bottom-2">
                    <div class="rounded-full p-2 bg-neutral-aurora text-xs text-blue-indigo font-noto-sans font-bold uppercase italic">
                        {item.highest_role}
                    </div>
                    <button type="button" aria-label="Confirmar alerta" class="w-[2rem] h-[2rem] bg-neutral-aurora rounded-md flex justify-center items-center font-noto-sans italic font-bold cursor-pointer">
                        <img src="/svg/default/edit.svg" alt="" aria-hidden="true" class="w-4 filter-blue-indigo" loading="lazy"/>
                    </button>
                </div>
            </article>
        {/each}
    </div>
</Section>