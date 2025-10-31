<script>
    import { Section } from "@/layouts/admin/";   
    import { Preview } from "@/components/admin/"
</script>

<form action="">
    <Section title="O básico">
        <div class="grid grid-cols-1 xl:grid-cols-[20rem_1fr] gap-5 mt-5">
            <div class="mb-3">
                <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                    Avatar de perfil
                </div>
                <Preview 
                    name="image" 
                    size="w-full h-[15rem] lg:h-[21rem]"
                    src=""
                    oninput=""
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
                        >
                            <option value="male">Masculino</option>
                            <option value="feminino">Feminino</option>
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
                        />
                    </div>
                </div>
                <div class="">
                    <div class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                        Cargos definidos
                    </div>
                    <div class="w-2/6 grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <div class="flex gap-2">
                            <input 
                                id="administrator"    
                                type="checkbox"
                                name="administrator"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="administrator">
                                Administrador
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                id="dev"    
                                type="checkbox"
                                name="dev"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="dev">
                                Desenvolvedor
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                id="streamer"    
                                type="checkbox"
                                name="streamer"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="streamer">
                                Locutor
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                id="writer"    
                                type="checkbox"
                                name="writer"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="writer">
                                Colunista
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                id="podcaster"    
                                type="checkbox"
                                name="podcaster"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="podcaster">
                                Podcaster
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <input 
                                id="marketing"    
                                type="checkbox"
                                name="marketing"
                                class="w-4" 
                            />
                            <label class="text-neutral-aurora font-noto-sans font-bold uppercase italic" for="marketing">
                                Marketing
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <Section title="Onde te achar">
        <div class="w-full flex flex-wrap lg:flex-nowrap gap-5">
            <select name="social" id="social" class="w-full lg:w-96 h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4">
                <option value="instagram">Instagram</option>
                <option value="facebook">Facebook</option>
                <option value="tiktok">TikTok</option>
                <option value="twitter">X (Twitter)</option>
                <option value="linkedin">LinkedIn</option>
                <option value="youtube">YouTube</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="telegram">Telegram</option>
                <option value="snapchat">Snapchat</option>
                <option value="pinterest">Pinterest</option>
                <option value="twitch">Twitch</option>
                <option value="discord">Discord</option>
                <option value="threads">Threads</option>
                <option value="reddit">Reddit</option>
            </select>
            <button type="submit" class="cursor-pointer flex items-center gap-2 bg-blue-skywave px-3 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
                <img src="/svg/default/plus.svg" class="w-5 filter-neutral-aurora" alt="" aria-hidden="true">Adicionar
            </button>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 mt-5">
            <div class="relative">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="instagram_1">
                    Instagram
                </label>
                <input
                    id="instagram_1"
                    type="url"
                    name="instagram[]"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
                <button type="button" class="absolute right-2 top-[3.5rem] transform -translate-y-1/2 bg-red-500 p-2 rounded-md">
                    <img src="/svg/default/trash.svg" class="w-4 filter-neutral-aurora" alt="Remover">
                </button>
            </div>
        </div>
    </Section>
    <Section title="Aprofundando">
        <div class="mt-5 mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="bibliography">
                Um pouco sobre você
            </label>
            <textarea
                id="bibliography"
                name="bibliography"
                rows="5"
                class="w-full bg-neutral-aurora font-noto-sans rounded-lg outline-none p-4"
            ></textarea>
        </div>
        <div class="mb-8">
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="likes">
                3 Coisas que você mais gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <input
                    id="likes"
                    type="text"
                    name="likes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
                <input
                    id="likes"
                    type="text"
                    name="likes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
                <input
                    id="likes"
                    type="text"
                    name="likes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
            </div>
        </div>
        <div>
            <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="unlikes">
                3 Gêneros de anime que você menos gosta
            </label>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <input
                    id="unlikes"
                    type="text"
                    name="unlikes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
                <input
                    id="unlikes"
                    type="text"
                    name="unlikes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
                <input
                    id="unlikes"
                    type="text"
                    name="unlikes"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                />
            </div>
        </div>
    </Section>
    <div class="flex justify-center mt-5 mb-8">
        <button type="submit" value="published" class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-blue-skywave rounded-xl text-blue-skywave text-xl font-bold font-noto-sans italic uppercase">
            Salvar
        </button>
    </div>
</form>
