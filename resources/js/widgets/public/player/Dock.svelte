<script>
    import { Modal } from "@/components/public"
    import { ListenerRequestForm } from "@/widgets/public/form"
    import { player, togglePlayPause } from "@/store" 
    import Icon from "@iconify/svelte";
</script>

<div class="h-[2rem]"></div>
<article class="w-full block xl:hidden fixed bottom-0 z-[50] bg-blue-skywave">
    <div class="container-player">
        <div class="h-[4rem] flex items-center justify-start gap-3">
            <button on:click={togglePlayPause} aria-label="play/pause" class="w-[40px] h-[40px] bg-neutral-aurora rounded-full  flex items-center justify-center">
                <Icon icon={$player.isPlaying ? "ic:round-pause" : "ic:round-play-arrow"} width="25" height="25" aria-hidden="true"/>
            </button>
            <Modal>
                <div slot="action" class="bg-neutral-aurora rounded-lg flex items-center justify-center gap-1 px-2 py-2 font-noto-sans font-bold uppercase italic">
                    <Icon icon="ic:sharp-queue-music" width="20" height="20" aria-hidden="true"/>
                    Faça seu pedido
                </div>
                <div slot="content">
                    <ListenerRequestForm/>
                </div>
            </Modal>
        </div>
    </div>
</article>