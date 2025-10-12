<script>
    import axios from "axios";
    import { useForm } from "@inertiajs/svelte";
    import { debounce } from "@/utils";
    import { metadata } from "@/store"

    // ------------------------------
    // Rate Limit para evitar flood
    // ------------------------------
    let storange = localStorage.getItem('akiba_rate_limit');
    let limit = false;
    let countdown = "";
    let interval;

    if (storange) {
        const rateLimit = new Date(storange);
        const now = new Date();

        if (now < rateLimit) {
            limit = true;

            interval = setInterval(() => {
                const diff = rateLimit - new Date();
                if (diff <= 0) {
                    clearInterval(interval);
                    localStorage.removeItem('akiba_rate_limit');
                    limit = false;
                    countdown = "";
                } else {
                    const minutes = Math.floor(diff / 60000);
                    const seconds = Math.floor((diff % 60000) / 1000);
                    countdown = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
                }
            }, 1000);
        } else {
            localStorage.removeItem('akiba_rate_limit');
        }
    }

    // ------------------------------
    // Formulário
    // ------------------------------
    const form = useForm({
        listener: localStorage.getItem('akiba_listener') || null,
        address: localStorage.getItem('akiba_address') || null,
        anime: null,
        music: [],
        message: null
    });

    let success = false;
    function onSubmit(event){
        event.preventDefault();

        $form.post('/create/listener/request', {
            onSuccess: () => {
                const expiraEm = new Date(Date.now() + 90 * 1000);
                localStorage.setItem('akiba_rate_limit', expiraEm.toISOString());
                
                success = true;
            },
        });
    }

    // ------------------------------
    // Controle dos dropdowns e seleção
    // ------------------------------
    let dropdown = false;
    let animes = [];
    let musics = [];

    function selectAnime(item) {
        dropdown = false;
        $form.anime = item;

        searchMusics(item.mal_id);
        document.getElementById('anime').value = item.title;    
    }

    // ------------------------------
    // Função de busca com debounce
    // ------------------------------
    function searchAnime(value) {
        if (!value) animes = [];

        axios.get(`https://api.jikan.moe/v4/anime?q=${value}`)
        .then(response => {
            const filtered  = response.data.data.filter(item => item.type === 'TV');
            animes = filtered.map(item => ({
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
    function searchMusics(value) {
        axios.get(`https://api.jikan.moe/v4/anime/${value}/full`)
        .then(response => {
            const themes = response.data.data.theme;

            const openings = (themes.openings || []).map(name => ({ name, type: 'op' }));
            const endings = (themes.endings || []).map(name => ({ name, type: 'ed' }));

            musics = { openings, endings };
        })
        .catch(error => console.error('Erro ao buscar músicas:', error));
    }
</script>

{#if $metadata.onair.listener_request_status === 1 && (!success && !limit)}
    <form class="w-full" on:submit={onSubmit}>
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="listener">
                Como gostaria de ser chamado?
            </label>
            <input
                id="listener"
                type="text"
                name="listener"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-black text-md rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Ayasumi"
                required={true}
                bind:value={$form.listener}
                on:blur={(e)=>localStorage.setItem('akiba_listener', e.target.value)}
                on:focus={() => localStorage.removeItem('akiba_listener')}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Vale apelido, nome social.. Só pra falar que o pedido é seu!
            </span>
        </div>
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="address">
                Qual é a sua cidade e estado?
            </label>
            <input
                id="address"
                type="text"
                name="address"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md text-black rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Salto - SP"
                required={true}
                bind:value={$form.address}
                on:blur={(e)=>localStorage.setItem('akiba_address', e.target.value)}
                on:focus={() => localStorage.removeItem('akiba_address')}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Não está no Brasil? Fala ai a cidade e país que está agora.
            </span>
        </div>
        <div class="mb-3 relative">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="anime">
                De qual anime você quer ouvir uma música?
            </label>
            <input
                id="anime"
                type="text"
                name="anime"
                class="w-full h-[2.5rem] bg-white font-noto-sans text-md text-black rounded-lg outline-none pl-4 border border-gray-400"
                placeholder="Ex: Konosuba"
                required={true}
                autocomplete="off"
                on:focus={() => dropdown = true}
                on:blur={() => dropdown = false}
                on:input={(e) => { debouncedSearch(e.target.value);}}
            />
            <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                Umas letras já bastam! E ai é só escolha o nome na lista.
            </span>
            {#if dropdown}
                {#if animes.length > 0}
                    <div class="absolute w-full bg-white border border-gray-200 rounded-2xl shadow-xl z-25 max-h-56 overflow-y-auto p-2">
                        {#each animes as item, i (item.id || i)}
                            <button on:mousedown={() => selectAnime(item)} class="cursor-pointer flex items-center gap-3 w-full p-2 rounded-xl hover:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500/30 transition-all duration-150">
                                <img
                                    src={item.image}
                                    alt={item.title}
                                    class="w-14 h-14 object-cover object-top rounded-lg border border-gray-100 shadow-sm shrink-0"
                                    loading="lazy"
                                />
                                <div class="flex flex-col items-start text-left">
                                    <div class="font-noto-sans font-semibold text-gray-900 text-sm line-clamp-1">
                                        {item.title}
                                    </div>
                                    <div class="font-noto-sans text-gray-500 text-xs">
                                        {item.year}
                                    </div>
                                </div>
                            </button>
                        {/each}
                    </div>
                {:else}
                    <div class="absolute w-full bg-white border border-gray-200 rounded-2xl shadow-md z-25 p-5 flex flex-col items-center justify-center text-center text-gray-500 font-noto-sans text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                        <div class="font-noto-sans">
                            Nenhum anime encontrado ainda...
                        </div>
                        <div class="font-noto-sans text-xs text-gray-400 mt-1">
                            Digite algo pra começar a busca! 🎧
                        </div>
                    </div>
                {/if}
            {/if}
        </div>
        {#if $form.anime}
            <div class="mb-3 relative">
                <label class="text-md text-gray-700 font-noto-sans block mb-1" for="music">
                    Escolha uma música do anime
                </label>
                <select 
                    id="music" 
                    name="music" 
                    class="w-full h-[8rem] bg-white font-noto-sans text-md text-start text-black rounded-lg outline-none pl-4 pr-10 border border-gray-400 disabled:bg-gray-100"
                    required={true}
                    multiple
                    placeholder="Escolha uma música"
                    bind:value={$form.music}
                >
                    <optgroup label="Aberturas" class="text-gray-700 text-sm font-noto-sans font-bold italic uppercase">
                        {#each musics?.openings as item}
                            <option value={item} class="cursor-pointer text-sm text-gray-700 font-noto-sans font-normal not-italic normal-case truncate mt-2 mb-2 px-0 hover:p-3 hover:rounded-lg hover:bg-gray-400 hover:text-neutral-aurora checked:p-3 checked:rounded-lg checked:bg-gray-400 checked:text-neutral-aurora ">
                                {item.name}
                            </option>
                        {/each}
                    </optgroup>
                    <optgroup label="Encerramentos" class="text-gray-700 text-sm font-noto-sans font-bold italic uppercase">
                        {#each musics?.endings as item}
                            <option value={item} class="cursor-pointer text-sm text-gray-700 font-noto-sans font-normal not-italic normal-case truncate mt-2 mb-2 px-0 hover:p-3 hover:rounded-lg hover:bg-gray-400 hover:text-neutral-aurora checked:p-3 checked:rounded-lg checked:bg-gray-400 checked:text-neutral-aurora ">
                                {item.name}
                            </option>
                        {/each}
                    </optgroup>
                </select>
                <span class="text-[0.8rem] text-gray-500 font-noto-sans mt-1 block">
                    Primeiro escolhe um anime. Depois a música é simples!
                </span>
            </div>
        {/if}
        <div class="mb-3">
            <label class="text-md text-gray-700 font-noto-sans block mb-1" for="message">
                Escreva uma mensagem
            </label>
            <textarea 
                id="message" 
                name="message"
                rows="4"
                class="w-full bg-white font-noto-sans text-md text-black rounded-lg outline-none p-4 border border-gray-400 resize-none"
                placeholder="Deixe uma mensagem amigavel"
                required={true}
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

{#if $metadata.onair.listener_request_status === 0}
    <dl class="h-[25rem] py-3">
        <dt class="mb-4 text-sm font-noto-sans text-gray-500">
            Foi mal... Você não pode enviar um pedido agora. 😭
        </dt>
        <dd class="text-sm font-noto-sans text-gray-500">
            O programa não tá rolando ao vivo agora, ou {$metadata.onair.user.gender === "m" ? "o DJ" : "a DJ"} {$metadata.onair.user.nickname} quer dar uma pausa nos pedidos por enquanto, viu? 
            Mas fica de boa, daqui a pouco, você vai poder mandar a sua música! 💬🎶        
        </dd>
    </dl>
{/if}

{#if success}
    <dl class="h-[25rem] py-3">
        <dt class="mb-4 text-sm font-noto-sans text-gray-500">
            Prontinho! Seu pedido foi enviado com sucesso. 💌
        </dt>
        <dd class="text-sm font-noto-sans text-gray-500">
            O seu pedido já tá a caminho! {$metadata.onair.user.gender === "m" ? "O DJ" : "A DJ"} {$metadata.onair.user.nickname} vai atender você em instantes. 
            Fica por aí que a programação tá demais! 🔥        
        </dd>
    </dl>
{/if}

{#if limit}
    <dl class="h-[25rem] py-3">
        <dt class="mb-4 text-sm font-noto-sans text-gray-500">
            Ui… já tá com saudade {$metadata.onair.user.gender === "m" ? "do DJ" : "da DJ"} {$metadata.onair.user.nickname}😏
        </dt>
        <dd class="text-sm font-noto-sans text-gray-500 leading-relaxed">
            Calma(a)! {$metadata.onair.user.gender === "m" ? "O DJ" : "A DJ"} {$metadata.onair.user.nickname} ainda tá curtindo o seu último pedido. 💃
            Aguenta só mais um pouquinho que você poderá mandar outro pedido em <strong>{countdown}</strong>. ⏳🔥
        </dd>
    </dl>
{/if}