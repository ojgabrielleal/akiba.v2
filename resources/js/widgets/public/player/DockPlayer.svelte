<script>
    import { Modal } from "@/components/public"
    import { ListenerRequestForm } from "@/widgets/public/form"
    import { player, togglePlayPause } from "@/store" 
</script>

<article class="block xl:hidden fixed bottom-6 right-6 z-[50] bg-blue-skywave rounded-full shadow-lg text-white">
    <div class="flex items-center justify-center p-2 gap-2">
        <button on:click={togglePlayPause} aria-label="play/pause" class="w-[50px] h-[50px] bg-neutral-aurora/50 rounded-full flex items-center justify-center">
            {#if $player.playing}
                <img src="/svg/default/pause.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
            {:else}
                <img src="/svg/default/play.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
            {/if}
        </button>
        <Modal>
            <div slot="action" class="w-[50px] h-[50px] rounded-full flex items-center justify-center">
                <img src="/svg/default/music.svg" alt="" aria-hidden="true" class="w-5 filter-neutral-aurora"/>
            </div>
            <div slot="content">
                <ListenerRequestForm/>
            </div>
        </Modal>
    </div>
</article>