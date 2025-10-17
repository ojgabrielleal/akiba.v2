<script>
    import { Modal } from "@/components/public"
    import { ListenerRequestForm } from "@/widgets/public/form"
    import { player, togglePlayPause, setVolume, metadata } from "@/store"
    import Icon from "@iconify/svelte";
</script>

<!--Frase do locutor acima do player principal-->
<article class="mt-9 lg:mt-15 bg-blue-ocean">
    <div class="container-player w-full flex justify-center relative">
        <div class="hidden lg:block absolute -top-7 left-0">
            <img src="/img/default/rains.webp" alt="" aria-hidden="true" class="w-[5rem] transform -scale-x-100 -scale-y-100"/>
        </div>
        <!-- svelte-ignore a11y_distracting_elements -->
        <marquee class="w-5xl relative flex overflow-x-hidden marquee-container">
            <div class="whitespace-nowrap w-full md:w-auto text-neutral-aurora py-4 text-3xl font-noto-sans font-bold uppercase italic">
                <span class="mx-4">{$metadata.onair.phrase}</span>
            </div>
        </marquee>
        <div class="hidden lg:block absolute bottom-0 right-4 z-10">
            <img src={$metadata.onair.image} alt="" aria-hidden="true" class="w-[8rem]"/>
        </div>
        <div class="hidden lg:block absolute -top-8 right-0 z-10">
            <img src="/img/default/rains.webp" alt="" aria-hidden="true" class="w-[5rem]"/>
        </div>
    </div>
</article>

<!--Container que engloba o player inteiro mais os anuncios abaixo-->
<div class="container-player">
    <article class="flex gap-5"> <!--Essa div é o flex inicial que engloba os demais blocos separados como de dados ( programa, locutor, música tocando), avatar e controles, mecher no gap meche nos espaçamento entre esses blocos -->
        <!-- Primeira parte do player ( Locutor, Programa, Música tocando)-->
        <div class="w-full lg:w-[45rem] mt-4 lg:mt-23">
            <!--Programa e locutor-->
            <dl class="flex flex-wrap xl:flex-nowrap items-center gap-5">
                <dt class="w-[16rem]">
                    <img src={$metadata.onair.program.image} alt={`Programa ${$metadata.onair.program.name}`}/>
                </dt>
                <dd class="text-gray-500">
                    <Icon icon="bi:chevron-double-right" width="25" height="25" aria-label="hidden"/>
                </dd>
                <dt>
                    <div class="text-orange-amber font-noto-sans uppercase">
                        {#if $metadata.onair.user.gender === "male"}
                            Com o DJ:
                        {/if}
                        {#if $metadata.onair.user.gender === "female"}
                            Com a DJ:
                        {/if}
                    </div>
                    <div class="w-full text-neutral-aurora text-3xl font-noto-sans font-bold uppercase italic line-clamp-1">
                        {$metadata.onair.user.nickname}
                    </div>
                    <div class={`${$metadata.onair.category === "auto" ? "bg-purple-mystic" : $metadata.onair.category === "record" ? "bg-orange-amber" : "bg-green-forest"} mt-[0.4rem] w-[6rem] rounded-xl text-center text-sm text-neutral-aurora font-noto-sans font-bold italic uppercase`}>
                        {#if $metadata.onair.category === "auto"}
                            Robô
                        {:else if $metadata.onair.category === "record"}
                            Gravado
                        {:else}
                            Humano
                        {/if}
                    </div>
                </dt>
                <dd class="text-gray-500 hidden xl:block">
                    <Icon icon="bi:chevron-double-right" width="25" height="25" aria-label="hidden"/>
                </dd>
            </dl>
            <!--Música tocando-->
            <dl class="flex gap-3 items-end mt-14 lg:mt-10">
                <dt class="w-[5rem] shrink-0">
                    {#if $metadata.stream.capa_musica === "https://player.painelcast.com/img/img-capa-artista-padrao.png"}
                        <img src="/img/default/no_cover.webp" on:error={(e) => e.target.src = '/img/default/no_cover.webp'} alt="" aria-hidden="true" class="rounded-lg"/>
                    {:else}
                        <img src={$metadata.stream.capa_musica} on:error={(e) => e.target.src = '/img/default/no_cover.webp'} alt="" aria-hidden="true" class="rounded-lg"/>
                    {/if}
                </dt>
                <dd>
                    <div class="text-orange-amber font-noto-sans uppercase italic">
                        Tocando agora:
                    </div>
                    <div class="text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic line-clamp-2">
                        {decodeURIComponent(escape($metadata.stream.musica_atual))}
                    </div>
                </dd>
            </dl>
        </div>
        <!-- Segunda parte do player ( Avatar )-->
        <div class="hidden lg:block mt-5">
            <div class="w-[20rem] h-[25rem]">
                <img src={$metadata.onair.user.avatar} alt="" aria-label="hidden" class="object-cover w-full h-full"/>
            </div>
        </div>
        <!-- Terceira parte do player ( Controles e botão de pedidos )-->
        <div class="w-[14rem] hidden xl:flex flex-col justify-end items-center gap-3 mb-8">
            <!--Bloco informativo sobre o status do programa ("Programa gravado, locutor no ar etc")-->
            <div class="w-full px-3 mb-8">
                <dl class={`${$metadata.onair.category === "auto" ? "bg-purple-mystic" : $metadata.onair.category === "record" ? "bg-orange-amber" : "bg-green-forest"} p-3 flex gap-2 justify-center items-center rounded-md`}>
                    <dt>
                        {#if $metadata.onair.category === "auto"}
                            <Icon icon="pixel:robot-solid" width="35" height="35" aria-label="hidden"/>
                        {/if}
                        {#if $metadata.onair.category === "record"}
                            <Icon icon="streamline:tape-cassette-record-solid" width="35" height="35" aria-label="hidden"/>
                        {/if}
                        {#if $metadata.onair.category === "live"}
                            <Icon icon="fa7-solid:tower-cell" width="35" height="35" aria-label="hidden"/>
                        {/if}
                    </dt>
                    <dd class="font-noto-sans font-medium italic uppercase text-center leading-[1rem]">
                        {#if $metadata.onair.category === "auto"}
                            Programação automática
                        {/if}
                        {#if $metadata.onair.category === "record"}
                            Programa gravado
                        {/if}
                        {#if $metadata.onair.category === "live"}
                            {#if $metadata.onair.user.gender === "male"}
                                Locutor <br/> ao vivo agora
                            {/if}
                            {#if $metadata.onair.user.gender === "female"}
                                Locutora <br/> ao vivo agora
                            {/if}
                        {/if}
                    </dd>
                </dl>
            </div>
            <!--Controles do player-->
            <div class="w-[14rem] flex justify-center px-3">
                <dl>
                    <dt class="ml-3 text-neutral-aurora text-xl font-noto-sans font-bold uppercase italic">
                        Dê o
                    </dt>
                    <dd class={`font-noto-sans font-extrabold uppercase italic  ${$player.playing ? "text-5xl text-orange-amber" : "text-6xl text-blue-skywave"}`}>
                        {$player.playing ? "Pause" : "Play"}
                    </dd>
                </dl>
                <button on:click={togglePlayPause} class={`${$player.playing ? "bg-orange-amber" : "bg-blue-skywave"} cursor-pointer w-[3.5rem] h-[3.5rem] rounded-full flex justify-center items-center`}>
                    <Icon icon={$player.playing ? "ic:round-pause" : "ic:round-play-arrow"}  width="30" height="30" class="text-blue-midnight" aria-label="hidden"/>
                </button>
            </div>
            <div class="w-full px-3">
                <input   
                    type="range" 
                    name="volume" 
                    id="volume" 
                    class="w-full accent-orange-amber"
                    min="0" 
                    max="1" 
                    step="0.01"
                    value={$player.volume}
                    on:input={(e) => setVolume(e.target.value)}
                />
            </div>
            <!--Botão e modal de pedidos músicais-->
            <Modal>
                <div slot="action" class="cursor-pointer w-full py-2 px-3 border-1 border-neutral-aurora rounded-full text-blue-skywave text-xl font-noto-sans font-bold italic uppercase">
                    & Faça seu <strong class="text-orange-amber">Pedido</strong>
                </div>
                <div slot="content">
                    <ListenerRequestForm/>
                </div>
            </Modal>
        </div>
    </article>
    <!--Anúncios-->
    <div class="mt-10 lg:mt-0 mb-10 flex flex-wrap lg:flex-nowrap gap-5 justify-between">
        <div class="w-full h-[8rem] bg-neutral-aurora">
        </div>
        <div class="w-full h-[8rem] bg-neutral-aurora hidden lg:block">
        </div>
    </div>
</div>
