<script>
    export let close = () => {};
    export let show_id = null;

    import { useForm, page } from "@inertiajs/svelte";
    import { Preview } from "@/components/admin";
    import axios from "axios";
    import Icon from "@iconify/svelte";

    $: ({ streamers } = $page.props);

    $: form = useForm({
        is_active: 1,
        name: null,
        is_all: 0,
        image: null,
        user_id: null,
        has_schedule: 1,
        schedules: [{ time: null, day: null }],
    });

    $: if (show_id) {
        axios.get(`/painel/radio/get/show/${show_id}`).then((response) => {
            $form.is_active = response.data.is_active;
            $form.name = response.data.name;
            $form.image = response.data.image;
            $form.is_all = Number(response.data.is_all);
            $form.user_id = response.data.user.id;
            $form.has_schedule = response.data.has_schedule;
            $form.schedules = response.data.schedules
                ? response.data.schedules
                : { time: null, day: null };
        });
    }

    function addSchedule() {
        $form.schedules = [...$form.schedules, { time: null, day: null }];
    }

    function removeSchedule(index) {
        $form.schedules = $form.schedules.filter((_, i) => i !== index);
    }

    function onSubmit(event) {
        event.preventDefault();

        let url = show_id ? `/painel/radio/update/show/${show_id}` : "/painel/radio/create/show";
        $form.post(url, {
            onSuccess: () => close(),
        });
    }
</script>

<form onsubmit={onSubmit}>
    <div class="mb-4">
        <Preview
            size="w-full h-[10rem]"
            name="image"
            src={$form.image}
            oninput={(event) => ($form.image = event.target.files[0])}
        />
    </div>
    <div class="mb-4">
        <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
            Programa
        </label>
        <input
            id="name"
            type="text"
            name="name"
            class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
            bind:value={$form.name}
        />
    </div>
    <div class="mb-4">
        <div class="text-md text-gray-700 font-noto-sans mb-2">
            Este programa está ativo?
        </div>
        <div class="flex items-center gap-2 mb-1">
            <input
                id="open"
                type="radio"
                name="is_active"
                value={1}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_active}
            />
            <label for="open" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Sim
            </label>
        </div>
        <div class="flex items-center gap-2">
            <input
                id="close"
                type="radio"
                name="is_active"
                value={0}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_active}
            />
            <label for="close" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Não
            </label>
        </div>
    </div>
    <div class="mb-4">
        <div class="text-md text-gray-700 font-noto-sans mb-2">
            Este programa estará disponível para todos os locutores?
        </div>
        <div class="flex items-center gap-2 mb-1">
            <input
                id="open"
                type="radio"
                name="is_all"
                value={1}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_all}
            />
            <label for="open" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Sim
            </label>
        </div>
        <div class="flex items-center gap-2">
            <input
                id="close"
                type="radio"
                name="is_all"
                value={0}
                class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                bind:group={$form.is_all}
            />
            <label for="close" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                Não
            </label>
        </div>
    </div>
    {#if $form.is_all === 1}
        <div class="mb-4">
            <div class="text-md text-gray-700 font-noto-sans mb-2">
                Este programa deverá ter horários semanais na grade de programação?
            </div>
            <div class="flex items-center gap-2 mb-1">
                <input
                    id="yes"
                    type="radio"
                    name="has_schedule"
                    value={1}
                    class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                    bind:group={$form.has_schedule}
                />
                <label for="yes" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                    Sim
                </label>
            </div>
            <div class="flex items-center gap-2">
                <input
                    id="no"
                    type="radio"
                    name="has_schedule"
                    value={0}
                    class="cursor-pointer w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                    bind:group={$form.has_schedule}
                />
                <label for="no" class="cursor-pointer text-md text-gray-700 font-noto-sans">
                    Não
                </label>
            </div>
        </div>
    {/if}
    {#if $form.is_all === 0}
        <div class="mb-4">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="name">
                Locutor
            </label>
            <select
                id="name"
                name="name"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                bind:value={$form.user_id}
            >
                {#each streamers as item}
                    <option value={item.id}>{item.nickname}</option>
                {/each}
            </select>
        </div>
    {/if}
    {#if $form.has_schedule === 1}
        <div class="flex items-center justify-center w-full mt-8 mb-5">
            <div class="relative w-full">
                <div class="absolute left-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
                <span class="absolute inset-0 flex items-center justify-center text-blue-skywave font-noto-sans font-bold uppercase italic">
                    Horários
                </span>
                <div class="absolute right-0 w-1/3 h-[0.1rem] bg-blue-skywave rounded-full top-1/2 -translate-y-1/2"></div>
            </div>
        </div>
        <button onclick={addSchedule} type="button" class="cursor-pointer mb-2 flex items-center gap-[0.1rem] text-blue-skywave text-md font-noto-sans">
            <Icon icon="mynaui:plus-solid" width="20" height="20" aria-hidden="true"/>
            Adicionar horário
        </button>
        {#each $form.schedules as schedule, index}
            <div class="mb-4 border border-gray-400 p-4 rounded-lg">
                <div class="mb-2">
                    <label class="text-md text-gray-700 font-noto-sans block mb-1" for="day">
                        Dia da semana
                    </label>
                    <select
                        id="day"
                        name="day"
                        class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                        bind:value={schedule.day}
                    >
                        <option value="dom">Domingo</option>
                        <option value="seg">Segunda</option>
                        <option value="ter">Terça</option>
                        <option value="qua">Quarta</option>
                        <option value="qui">Quinta</option>
                        <option value="sex">Sexta</option>
                        <option value="sab">Sábado</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="text-md text-gray-700 font-noto-sans block mb-1" for="time">
                        Horário
                    </label>
                    <input
                        id="time"
                        type="text"
                        name="time"
                        class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                        bind:value={schedule.time}
                    />
                </div>
                <button onclick={() => removeSchedule(index)} type="button" class="cursor-pointer mt-4 flex items-center gap-[0.2rem] text-blue-skywave text-md font-noto-sans">
                    <Icon icon="fa7-solid:remove" width="14" height="14" aria-hidden="true"/>
                    Remover
                </button>
            </div>
        {/each}
    {/if}
    <button type="submit" class="cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
        {#if show_id}
            Atualizar
        {:else}
            Cadastrar
        {/if}
    </button>
</form>
