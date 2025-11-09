<script>
    import { onMount } from "svelte"
    import { useForm, page } from "@inertiajs/svelte"
    import { Section } from "@/layouts/admin/";   
    import { Preview } from "@/components/admin/"
    import Default from "@/data/Default.json"

    $: ({ profile } = $page.props);

    $:if(profile){
        console.log(profile)
    }

    $: form = useForm({
        _method: null,
        name: null,
        nickname: null,
        gender: null,
        avatar: null,
        birthday: null,
        city: null,
        state: null,
        country: null,
        bibliography: null,
        external_links: [],
        likes: [],
    })

    onMount(()=>{
        if(profile){
            $form._method = "PUT",
            $form.name = profile.name,
            $form.nickname = profile.nickname,
            $form.gender = profile.gender,
            $form.avatar = profile.avatar,
            $form.birthday = profile.birthday,
            $form.city = profile.city,
            $form.state = profile.state,
            $form.country = profile.country,
            $form.bibliography = profile.bibliography,
            $form.external_links = profile.external_links,
            $form.likes = profile.likes 
        }
    })

    let selectedNewExternalLink = Default.social[0].name
    function addExternalLink(){
        $form.external_links = [
            ...$form.external_links,
            { name: selectedNewExternalLink, url: "" } 
        ];
    }

    function removeExternalLink(index) {
        $form.external_links.splice(index, 1);
        $form.external_links = $form.external_links
    }
    
    function onSubmit(){
        $form.post(`/painel/profile/update/${profile?.id}`);
    }
</script>

<form on:submit|preventDefault={onSubmit}>
    <Section title="O básico">
        <div class="grid grid-cols-1 xl:grid-cols-[15rem_1fr] gap-5 items-center">
            <div class="mb-3">
                <Preview 
                    name="image" 
                    standard="w-full h-[15rem] rounded-full"
                    view="w-full h-[25rem] lg:h-[15rem] rounded-lg lg:rounded-full object-contain lg:object-cover object-top bg-neutral-aurora"
                    src={$form.avatar} 
                    oninput={event => $form.avatar = event.target.files[0]} 
                    required={profile ? false : true}
                />
            </div>
            <div>
                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr_8rem_1fr] gap-5 mb-8">
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="name">
                            Nome completo
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.name}
                            required
                        />
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="nickname">
                            Apelido
                        </label>
                        <input
                            id="nickname"
                            type="text"
                            name="nickname"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.nickname} 
                            required                       
                        />
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="gender">
                            Gênero
                        </label>
                        <select
                            id="gender"
                            name="gender"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.gender}
                            required
                        >
                            <option value="male">Masculino</option>
                            <option value="female">Feminino</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="birthday">
                            Data de nascimento
                        </label>
                        <input
                            id="birthday"
                            type="date"
                            name="birthday"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.birthday}
                            required
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-8">
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="city">
                            Cidade
                        </label>
                        <input
                            id="city"
                            type="text"
                            name="city"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.city}   
                            required                     
                        />
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="state">
                            Estado
                        </label>
                        <input
                            id="state"
                            type="text"
                            name="state"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.state}    
                            required                    
                        />
                    </div>
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="country">
                            País
                        </label>
                        <input
                            id="country"
                            type="text"
                            name="country"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            defaultValue="Brasil"
                            bind:value={$form.country}  
                            required                      
                        />
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <Section title="Onde encontrar">
        <div class="w-full flex flex-wrap lg:flex-nowrap gap-5">
            <select 
                name="social" 
                id="social" 
                class="w-full lg:w-96 h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                bind:value={selectedNewExternalLink} 
            >
                {#each Default.social as item}
                    <option value={item.name}>{item.name}</option>
                {/each}
            </select>
            <button on:click={addExternalLink} type="button" class="cursor-pointer flex items-center gap-2 bg-blue-skywave px-3 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
                <img src="/svg/default/plus.svg" class="w-5 filter-neutral-aurora" alt="" aria-hidden="true">Adicionar
            </button>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mt-5">
            {#each $form.external_links as item, index}
                <div class="relative">
                    <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for={item.name}>
                        {item.name}
                    </label>
                    <input
                        id={item.name}
                        type="url"
                        name={item.name}
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4 pr-14"
                        bind:value={item.url}
                        required
                    />
                    <button on:click={() => removeExternalLink(index)} type="button" class="cursor-pointer absolute right-2 top-[3.5rem] transform -translate-y-1/2 bg-red-500 p-2 rounded-md">
                        <img src="/svg/default/trash.svg" class="w-4 filter-neutral-aurora" alt="Remover">
                    </button>
                </div>
            {/each}
        </div>
    </Section>
    <Section title="Aprofundando">
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="bibliography">
                Biografia
            </label>
            <textarea
                id="bibliography"
                name="bibliography"
                rows="5"
                class="w-full bg-neutral-aurora font-noto-sans rounded-lg outline-none p-4"
                bind:value={$form.bibliography}
                required
            ></textarea>
        </div>
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="likes">
                3 Gêneros de anime que você mais gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {#each $form.likes.filter((item)=> item.category === 'like') as item}
                    <select
                        id={item.id}
                        name={item.id}
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={item.content}
                        required
                    >
                        {#each Default.anime_gender as gender}
                            <option value={gender.value}>{gender.name}</option>
                        {/each}
                    </select>
                {/each}
            </div>
        </div>
        <div>
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="unlikes">
                3 Gêneros de anime que você menos gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {#each $form.likes.filter((item)=> item.category === 'unlike') as item}
                    <select
                        id={item.id}
                        name={item.id}
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={item.content}
                        required
                    >
                        {#each Default.anime_gender as gender}
                            <option value={gender.value}>{gender.name}</option>
                        {/each}
                    </select>
                {/each}
            </div>
        </div>
    </Section>
    <div class="flex justify-center mt-5 mb-8">
        <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
            Atualizar
        </button>
    </div>
</form>
