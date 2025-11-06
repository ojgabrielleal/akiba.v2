<script>
    export let close = () => {};
    export let pollId = null;

    import { onMount } from 'svelte';
    import { useForm } from "@inertiajs/svelte";
    import axios from "axios";

    let form = useForm({
        question: null,
        option_one: null,
        option_two: null, 
        option_three: null,
        option_four: null 
    });

    function onSubmit(event){
        event.preventDefault();

        if(pollId){
            $form.put(`/painel/medias/update/poll/${pollId}`, {
                onSuccess: () => close(),
            });
        }else{
            $form.post("/painel/medias/create/poll", {
                onSuccess: () => close(),
            });
        } 
    }

    onMount(()=>{
        if(pollId){
            axios.get(`/painel/medias/get/poll/${pollId}`).then((response) => {
                $form.question = response.data.question;
                $form.option_one = response.data.options[0].option
                $form.option_two = response.data.options[1].option
                $form.option_three = response.data.options[2].option
                $form.option_four = response.data.options[3].option
            });
        }
    })
</script>

<form on:submit={onSubmit}>
    <div class="mb-4">
        <label for="question" class="text-md text-gray-700 font-noto-sans block mb-1">
            Pergunta
        </label>
        <input
            id="question"
            type="text"
            name="question"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.question}
        />
    </div>

    <div class="px-4 mb-4 rounded-lg border border-gray-400">
        <div class="mt-5 mb-4">
            <label for="option_one" class="text-md text-gray-700 font-noto-sans block mb-1">
                1º Opção
            </label>
            <input
                id="option_one"
                name="option_one"
                type="text"
                placeholder="Digite a primeira opção"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.option_one}
            />
        </div>
        <div class="mb-4">
            <label for="option_two" class="text-md text-gray-700 font-noto-sans block mb-1">
                2º Opção
            </label>
            <input
                id="option_two"
                name="option_two"
                type="text"
                placeholder="Digite a segunda opção"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.option_two}
            />
        </div>
        <div class="mb-4">
            <label for="option_three" class="text-md text-gray-700 font-noto-sans block mb-1">
                3º Opção
            </label>
            <input
                id="option_three"
                name="option_three"
                type="text"
                placeholder="Digite a terceira opção"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.option_three}
            />
        </div>
        <div class="mb-6">
            <label for="option_four" class="text-md text-gray-700 font-noto-sans block mb-1">
                4º Opção
            </label>
            <input
                id="option_four"
                name="option_four"
                type="text"
                placeholder="Digite a quarta opção"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.option_four}
            />
        </div>
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        {#if pollId}
            Atualizar
        {:else}
            Cadastrar
        {/if}
    </button>
</form>
