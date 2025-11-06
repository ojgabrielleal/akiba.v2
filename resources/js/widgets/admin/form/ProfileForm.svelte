<script>
    import { useForm, page } from "@inertiajs/svelte"
    import { Section } from "@/layouts/admin/";   
    import { Preview } from "@/components/admin/"
    import Default from "@/data/Default.json"

    $: ({ profile } = $page.props);

    $:form = useForm({
        _method: "PUT",
        name: profile?.name,
        nickname: profile?.nickname,
        gender: profile?.gender,
        avatar: profile?.avatar,
        birthday: profile?.birthday,
        email: profile?.email,
        city: profile?.city,
        state: profile?.state,
        country: profile?.country,
        bibliography: profile?.bibliography,
        external_links: profile?.external_links,
        likes: profile?.likes
    })

    let selectNewExternalLink = Default.social[0].name
    function addExternalLink(){
        $form.external_links = [
            ...$form.external_links,
            { name: selectNewExternalLink, url: "" } 
        ];
    }

    function removeExternalLink(index) {
        $form.external_links.splice(index, 1);
        $form.external_links = $form.external_links
    }

    function onSubmit(event){
        event.preventDefault();
        $form.post(`/painel/profile/update/${profile?.id}`);
    }
</script>

<form on:submit={onSubmit}>
    <Section title="O básico">
        <div class="grid grid-cols-1 xl:grid-cols-[15rem_1fr] gap-5 items-center">
            <div class="mb-3">
                <Preview 
                    name="image" 
                    standard="w-full h-[15rem] rounded-full"
                    view="w-full h-[25rem] lg:h-[15rem] rounded-lg lg:rounded-full object-contain lg:object-cover object-top bg-neutral-aurora"
                    src={$form.avatar} 
                    oninput={event => $form.avatar = event.target.files[0]} 
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
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mb-8">
                    <div>
                        <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="email">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                            bind:value={$form.email}                        
                        />
                    </div>
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
                bind:value={selectNewExternalLink} 
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
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={item.url}
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
            ></textarea>
        </div>
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="likes">
                3 Gêneros de anime que você mais gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {#each $form.likes.filter(item => item.category === "like") as item}
                    <input
                        id={item.id}
                        type="text"
                        name={item.id}
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={item.content}
                    />
                {/each}
            </div>
        </div>
        <div>
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="unlikes">
                3 Gêneros de anime que você menos gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {#each $form.likes.filter(item => item.category === "unlike") as item, index}
                    <input
                        id={item.id}
                        type="text"
                        name={item.id}
                        class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                        bind:value={item.content}
                    />
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
