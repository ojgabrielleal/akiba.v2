<script>
    import axios from "axios";
    import { useForm } from "@inertiajs/svelte";
    import { debounce } from "@/utils";
    import { cast } from "@/store" 

    // ------------------------------
    // Formulário Inertia
    // ------------------------------
    $: success = false;
    const form = useForm({
        listener: null,
        address: null,
        anime: null,
        music: null,
        message: null
    });

    function onSubmit(event){
        event.preventDefault();
        $form.post('/create/listener/request', {
            onSuccess: () => {
                success = true;
                setTimeout(()=> success = false, 60 * 1000);
            },
        });
    }

    // ------------------------------
    // Controle do dropdown e seleção
    // ------------------------------
    let dropdown = false;
    let animesList = [];
    let animeSelected = null;

    function selectAnime(item) {
        animeSelected = item;
        $form.anime = item;
        dropdown = false;
        searchMusics(item.mal_id);
    }
    
    // ------------------------------
    // Função de busca com debounce
    // ------------------------------
    function searchAnime(value) {
        if (!value) {
            animesList = [];
            return;
        }

        axios.get(`https://api.jikan.moe/v4/anime?q=${value}`)
        .then(response => {
            const filtered  = response.data.data.filter(item => item.type === 'TV');
            animesList = filtered.map(item => ({
                title: item.title,
                mal_id: item.mal_id,
                image: item.images.jpg.image_url,
                year: item.aired.from ? new Date(item.aired.from).getFullYear() : 'N/A'
            }));       
        })
        .catch(error => console.error('Erro ao buscar animes:', error));
    }
    const debouncedSearch = debounce(searchAnime, 500);

    // ------------------------------
    // Buscar músicas do anime
    // ------------------------------
    let musicsList = null;
    function searchMusics(malId) {
        axios.get(`https://api.jikan.moe/v4/anime/${malId}/full`)
        .then(response => {
            const themes = response.data.data.theme;

            const openings = (themes.openings || []).map(name => ({ name, type: 'op' }));
            const endings = (themes.endings || []).map(name => ({ name, type: 'ed' }));

            musicsList = { openings, endings };
        })
        .catch(error => console.error('Erro ao buscar músicas:', error));
    }
</script>

{#if $cast.onair.listener_request_status === 1 && success === false}
    <form class="w-full" on:submit={onSubmit}>
        <!-- Nome / Apelido -->
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="listener">
                Como gostaria de ser chamado?
            </label>
            <input
                id="listener"
                type="text"
                name="listener"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Ayasumi"
                bind:value={$form.listener}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Vale apelido, nome social.. Só pra falar que o pedido é seu!
            </span>
        </div>

        <!-- Cidade / Estado -->
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="address">
                Qual é a sua cidade e estado?
            </label>
            <input
                id="address"
                type="text"
                name="address"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Salto - SP"
                bind:value={$form.address}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Não está no Brasil? Fala ai a cidade e país que está agora.
            </span>
        </div>

        <!-- Busca de Anime -->
        <div class="mb-3 relative">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="anime">
                De qual anime você quer ouvir uma música?
            </label>
            <input
                id="anime"
                type="text"
                name="anime"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Konosuba"
                on:input={(e) => { debouncedSearch(e.target.value); dropdown = true; }}
                on:blur={() => setTimeout(() => dropdown = false, 150)}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Umas letras já bastam! E ai é só escolha o nome na lista.
            </span>

            {#if dropdown && animesList.length > 0}
                <div class="w-full bg-white flex flex-col gap-5 p-3 absolute z-25 max-h-40 overflow-y-auto shadow-lg rounded-lg">
                    {#each animesList as item}
                        <button on:mousedown={() => selectAnime(item)} class="flex items-start gap-3 p-2 min-h-[4rem] rounded-lg cursor-pointer transition-colors">
                            <img src={item.image} alt="" aria-hidden="true" class="w-[4rem] h-[4rem] object-cover object-top rounded-md shrink-0"/>
                            <div class="w-full flex flex-col items-start ">
                                <div class="text-start font-noto-sans font-semibold text-gray-900 text-sm leading-tight">
                                    {item.title}
                                </div>
                                <div class="font-noto-sans font-medium text-gray-500 text-sm" aria-hidden="true">
                                    {item.year}
                                </div>
                            </div>
                        </button>
                    {/each}
                </div>
            {/if}
        </div>

        <!-- Seleção de Música -->
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="music">
                Escolha uma música do anime
            </label>
            <select
                id="music"
                name="music"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md rounded-lg outline-none pl-4 border border-gray-400 disabled:bg-gray-200"
                disabled={!animeSelected}
                bind:value={$form.music}
            >
                {#if animeSelected}
                    <option value={null} disabled>
                        Selecione uma música
                    </option>
                {/if}
                <optgroup label="Openings">
                    {#each musicsList?.openings as item}
                        <option value={item}>{item.name}</option>
                    {/each}
                </optgroup>
                <optgroup label="Endings">
                    {#each musicsList?.endings as item}
                        <option value={item}>{item.name}</option>
                    {/each}
                </optgroup>
            </select>
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Primeiro escolhe o anime, depois a música é simples!
            </span>
        </div>

        <!-- Mensagem -->
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="message">
                Escreva uma mensagem
            </label>
            <textarea 
                id="message" 
                name="message"
                rows="4"
                class="w-full bg-white font-noto-sans text-md rounded-lg outline-none p-4 border border-gray-400 resize-none"
                placeholder="Deixe uma mensagem amigavel"
                bind:value={$form.message}
            ></textarea>
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Vamos evitar ofensas! Se pedido pode não tocar por isso.
            </span>
        </div>

        <!-- Botão Enviar -->
        <button type="submit" class="cursor-pointer w-full bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
            Enviar
        </button>
    </form>
{/if}

{#if $cast.onair.listener_request_status === 0}
    <dl class="h-[25rem] py-3">
        <dt class="mb-4 text-sm font-noto-sans text-gray-500">
            Foi mal ai... Você não pode enviar um pedido agora. 😭
        </dt>
        <dd class="text-sm font-noto-sans text-gray-500">
            O programa não tá rolando ao vivo agora, ou o locutor resolveu dar uma pausa nos pedidos dos ouvintes por enquanto, viu? 
            Mas fica de boa, daqui a pouco, você vai poder mandar o seu de novo! 💬🎶        
        </dd>
    </dl>
{/if}

{#if success === true}
    <dl class="h-[25rem] py-3">
        <dt class="mb-4 text-sm font-noto-sans text-gray-500">
            Prontinho! Seu pedido foi enviado com sucesso. 💌
        </dt>
        <dd class="text-sm font-noto-sans text-gray-500">
            O seu pedido já tá a caminho! {$cast.onair.user.gender === "m" ? "O locutor" : "A locutora"} {$cast.onair.user.nickname} vai atender você em instantes. 
            Fica por aí que a programação tá demais! 🔥        
        </dd>
    </dl>
{/if}