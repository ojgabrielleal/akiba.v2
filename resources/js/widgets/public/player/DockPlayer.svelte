<script>
    import { Modal } from "@/components/public"
    import { ListenerRequestForm } from "@/widgets/public/form"
    import { player, togglePlayPause } from "@/store" 
    import Icon from "@iconify/svelte";
</script>

<article class="block xl:hidden fixed bottom-6 right-6 z-[50] bg-blue-skywave rounded-full shadow-lg text-white">
    <div class="flex items-center justify-center p-2 gap-2">
        <button on:click={togglePlayPause} aria-label="play/pause" class="w-[50px] h-[50px] bg-neutral-aurora/50 rounded-full flex items-center justify-center">
            <Icon icon={$player.isPlaying ? "ic:round-pause" : "ic:round-play-arrow"} width="30" height="30" aria-hidden="true"/>
        </button>
        <Modal>
            <div slot="action" class="w-[50px] h-[50px] rounded-full flex items-center justify-center">
                <Icon icon="ic:sharp-queue-music" width="25" height="25" aria-hidden="true"/>
            </div>
            <div slot="content">
                <ListenerRequestForm/>
            </div>
        </Modal>
    </div>
</article>