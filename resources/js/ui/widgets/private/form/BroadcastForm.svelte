<script>
    import { useForm, page, router } from "@inertiajs/svelte";
    import { Section } from "@/ui/components/private/";
    import { hasPermission } from "@/utils";
    import avatarJson from "@/data/broadcast/avatar.json";

    $: ({ programs   } = $page.props);

    let form = useForm({
        program: null,
        phrase: null,
        image: null,
    });
    
    const submit = () => {
        $form.post(`/painel/locucao/broadcast/start/${$form.program}`);
    }
</script>

<Section title="Meus Programas">
    <form on:submit|preventDefault={submit}>
        {#if programs.data.length > 0}
            <div class="flex flex-wrap justify-center gap-15 lg:gap-x-0 lg:gap-y-15 0 mt-10 mb-20">
                {#each programs.data as item}
                    <button on:click={() => {$form.program = item.uuid}} type="button" aria-label={item.name} class="flex-none cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-aurora/10 lg:last:border-0">
                        <img src={item.image} alt="" aria-hidden="true" loading="lazy" class={['w-60 transition duration-300 ease-in-out',
                            {'opacity-50 scale-90': $form.program === item.uuid},
                            {'opacity-100': $form.program !== item.uuid}
                        ]}/>
                    </button>
                {/each}
            </div>
        {/if}
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="phrase">
                Qual é a frase para esse programa?
            </label>
            <input 
                id="phrase"  
                type="text" 
                name="phrase"
                class="w-full h-12 bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4" 
                bind:value={$form.phrase}
            />
        </div>
        <div class="mb-15">
            <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                Escolha um icone
            </div>
            <div class="flex flex-wrap justify-center lg:justify-start gap-30 lg:gap-y-30 lg:gap-x-5 mt-28">
                {#each avatarJson as item, index}
                    <button on:click={() => {$form.image = item.url}} type="button" aria-label={`Icon ${index}`}  class={['cursor-pointer w-[9.55rem] h-12 flex justify-end items-end rounded-lg bg-neutral-aurora transition duration-300 ease-in-out', 
                        {'opacity-50 scale-90' : $form.image === item.url},
                        {'opacity-100' : $form.image !== item.url }
                    ]}>
                        <img src={item.url} alt="" aria-hidden="true" class="w-34 aspect-square" loading="lazy"/>
                    </button>
                {/each}
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                Iniciar
            </button>
        </div>
    </form>
</Section>
