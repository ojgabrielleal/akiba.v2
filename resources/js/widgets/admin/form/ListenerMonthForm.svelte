<script>
    export let close = () => {};

    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/components/admin";

    $: ({ listenerMonthFound } = $page.props);

    $: form = useForm({
        image: null,
        listener: listenerMonthFound?.listener,
        address: listenerMonthFound?.address,
        favorite_show: listenerMonthFound?.favorite_show,
        requests_total: listenerMonthFound?.total,
    });

    function onSubmit(event){
        event.preventDefault();

        $form.post('/painel/radio/create/listener/month', {
            onSuccess: () => close()
        })
    }
</script>

<form on:submit={onSubmit}>
    <div class="mb-4">
        <Preview
            standard="w-full h-[10rem] rounded-lg"
            name="image"
            oninput={(event) => ($form.image = event.target.files[0])}
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
            disabled={true}
            bind:value={$form.listener}
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
            disabled={true}
            bind:value={$form.address}
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
            disabled={true}
            bind:value={$form.favorite_show}
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
            disabled={true}
            bind:value={$form.requests_total}
        />
    </div>
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        Atualizar
    </button>
</form>