<script>
    export let close = () => {};
    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/components/admin";

    $: ({ listener_month_found } = $page.props);

    $: if(listener_month_found){
        console.log(listener_month_found)
    }

    $: form = useForm({
        image: null,
        listener: listener_month_found?.listener,
        address: listener_month_found?.address,
        favorite_show: listener_month_found?.onair?.program.name,
        requests_total: listener_month_found?.total,
    });

    function onSubmit(event){
        event.preventDefault();

        $form.post('/painel/radio/create/listenermonth', {
            onSuccess: () => close()
        })
    }
</script>

<form on:submit={onSubmit}>
    <div class="mb-4">
        <Preview
            size="w-full h-[10rem]"
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