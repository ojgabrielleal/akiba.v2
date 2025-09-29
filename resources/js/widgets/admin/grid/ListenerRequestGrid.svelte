<script>
    export let title = null;

    import { Section } from "@/layouts/admin/";
    import Icon from "@iconify/svelte";
</script>

<Section {title}>
    <div class="flex justify-center">
        <button
            type="submit"
            aria-label="parar de receber"
            class="cursor-pointer w-full lg:w-auto py-2 px-6 border-4 border-solid border-neutral-honeycream rounded-xl text-neutral-honeycream text-xl font-bold font-noto-sans italic uppercase"
        >
            Parar de receber
        </button>
    </div>
    <div class="flex flex-wrap gap-2 mt-10">
        <div class="w-[23.6rem] rounded-lg p-3 bg-blue-skywave">
            <span
                class="flex items-center gap-1.5 text-neutral-aurora text-[1.2rem] font-noto-sans font-bold italic"
            >
                <Icon icon="mdi:person-circle" width="20" height="20" />
                Beatriz Freitas Sales
            </span>
            <span
                class="mt-1 flex gap-1.5 text-neutral-aurora text-[1rem] font-noto-sans"
            >
                <Icon icon="tabler:map-pin-filled" width="20" height="20" />
                Rodinha das aguas pateadas - MS
            </span>
            <div class="flex items-center justify-center w-full mt-5 mb-5">
                <div class="relative w-full">
                    <div
                        class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"
                    ></div>
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <Icon
                            icon="streamline:ai-generate-music-spark-solid"
                            width="24"
                            height="24"
                            class="text-neutral-aurora"
                        />
                    </div>
                    <div
                        class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"
                    ></div>
                </div>
            </div>
            <div class="flex gap-3">
                <img
                    src="/img/default/listenerRequestMusicCover.png"
                    alt="capa da musica"
                    class="w-15 h-15 rounded-lg"
                />
                <div>
                    <span
                        class="block text-neutral-aurora text-sm font-noto-sans"
                    >
                        Anime: New Game!
                    </span>
                    <span
                        class="block text-neutral-aurora text-sm font-noto-sans"
                    >
                        Artista: Fourfolium
                    </span>
                    <span
                        class="block text-neutral-aurora text-sm font-noto-sans"
                    >
                        Música: Step by Step
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-center w-full mt-5 mb-5">
                <div class="relative w-full">
                    <div
                        class="absolute left-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"
                    ></div>
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <Icon
                            icon="basil:telegram-solid"
                            width="24"
                            height="24"
                            class="text-neutral-aurora"
                        />
                    </div>
                    <div
                        class="absolute right-0 w-2/5 h-[0.1rem] bg-white rounded-full top-1/2 -translate-y-1/2"
                    ></div>
                </div>
            </div>
            <span
                class="h-25 line-clamp-5 text-neutral-aurora text-sm font-noto-sans mb-7"
            >
                Lorem Ipsum is simply dummy text of the printing and typesetting
                industry. Lorem Ipsum has been the industry's standard dummy
                text ever since the 1500s, when an unknown printer took a galley
                of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into
                electronic typesetting, remaining essentially unchanged. It was
                popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop
                publishing software like Aldus PageMaker including versions of
                Lorem Ipsum.
            </span>
            <div class="flex justify-between">
                <div
                    class="flex items-center gap-1 text-neutral-aurora text-sm font-noto-sans font-bold italic"
                >
                    <Icon icon="mdi:clock" width="24" height="24" />
                    13:00
                </div>
                <button class="cursor-pointer text-neutral-aurora">
                    <Icon icon="material-symbols:save" width="24" height="24" />
                </button>
            </div>
        </div>
    </div>
</Section>
