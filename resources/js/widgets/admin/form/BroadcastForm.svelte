<script>
    export let title = null;

    import { useForm, page, router } from "@inertiajs/svelte";
    import { Section } from "@/layouts/admin/";
    import Onair from "@/data/admin/Onair.json";

    $: ({ shows, verify } = $page.props);

    function endBroadcast() {
        router.post("/painel/locucao/broadcast/end/");
    }

    $: form = useForm({
        show: null,
        phrase: null,
        image: null,
    });

    function onSubmit(event) {
        event.preventDefault();
        $form.post("/painel/locucao/broadcast/start/");
    }
</script>

{#if verify.onair === false && verify.streamer === false}
    <Section {title}>
        <form on:submit={onSubmit}>
            <div class="flex flex-wrap justify-center gap-15 lg:gap-x-0 lg:gap-y-15 0 mt-10 mb-20">
                {#each shows as item}
                    <button on:click={() => ($form.show = item.id)} type="button" aria-label={item.name} class="cursor-pointer lg:px-10 lg:border-r-2 lg:border-neutral-opacity lg:last:border-0">
                        <img src={item.image} alt="" aria-hidden="true" class={`w-60 transition duration-300 ease-in-out ${$form.show === item.id ? "opacity-50 scale-90" : "opacity-100"}`} loading="lazy"/>
                    </button>
                {/each}
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="phrase">
                    Qual é a frase para esse programa?
                </label>
                <input 
                    id="phrase"  
                    type="text" 
                    name="phrase"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4" 
                    bind:value={$form.phrase}
                />
            </div>
            <div class="mb-15">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block">
                    Escolha um icone
                </div>
                <div class="flex flex-wrap justify-center lg:justify-start gap-30 lg:gap-y-30 lg:gap-x-5 mt-[7rem]">
                    {#each Onair.icons as icon, index}
                        <button on:click={() => ($form.image = icon.url)} type="button" aria-label={`Icone ${index}`}  class={`cursor-pointer w-[9.55rem] h-[3rem] flex justify-end items-end rounded-lg bg-neutral-aurora transition duration-300 ease-in-out ${$form.image === icon.url ? "opacity-50 scale-90" : "opacity-100"} `}>
                            <img src={icon.url} alt="" aria-hidden="true" class="w-[8.5rem] aspect-square" loading="lazy"/>
                        </button>
                    {/each}
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-green-forest rounded-xl text-green-forest text-xl font-bold font-noto-sans italic uppercase">
                    Iniciar programa
                </button>
            </div>
        </form>
    </Section>
{/if}
{#if verify.onair === true && verify.streamer === true}
    <div class="flex justify-center mb-8">
        <button on:click={() => endBroadcast()} type="button" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-red-crimson rounded-xl text-red-crimson text-xl font-bold font-noto-sans italic uppercase">
            Encerrar programa
        </button>
    </div>
{/if}
