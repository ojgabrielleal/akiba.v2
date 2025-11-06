<script>
    export let close = () => {};

    import { onMount } from 'svelte';
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/components/admin";

    $: ({ listenerMonthFound } = $page.props);

    let form = useForm({
        image: null,
        listener: null,
        address: null,
        favorite_show: null,
        requests_total: null,
    });

    onMount(()=>{
        if(listenerMonthFound){
            $form.listener = listenerMonthFound.listener,
            $form.address = listenerMonthFound.address,
            $form.favorite_show = listenerMonthFound.favorite_show,
            $form.requests_total = listenerMonthFound.total
        }
    })

    function onSubmit(){
        $form.post('/painel/radio/create/listener/month', {
            onSuccess: () => close()
        })
    }
</script>

<form on:submit|preventDefault={onSubmit}>
    <div class="mb-4">
        <Preview
            standard="w-full h-[10rem] rounded-lg"
            name="image"
            oninput={(event) => ($form.image = event.target.files[0])}
            required={true}
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="listener">
            Ouvinte
        </label>
        <input
            id="listener"
            type="text"
            name="listener"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400 disabled:bg-gray-200"
            bind:value={$form.listener}
            disabled
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="address">
            Endereço
        </label>
        <input
            id="address"
            type="text"
            name="address"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400 disabled:bg-gray-200"
            bind:value={$form.address}
            disabled
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="favorite_show">
            Programa favorito
        </label>
        <input
            id="favorite_show"
            type="text"
            name="favorite_show"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400 disabled:bg-gray-200"
            bind:value={$form.favorite_show}
            disabled
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="requests_total">
            Quantidade de pedidos feitos
        </label>
        <input
            id="requests_total"
            type="text"
            name="requests_total"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400 disabled:bg-gray-200"
            bind:value={$form.requests_total}
            disabled
        />
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Atualizar
    </button>
</form>