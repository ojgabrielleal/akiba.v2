<script>
    import { Meta } from "@/meta";
    import { Core, Dock } from "@/widgets/public/player"

    // Define background color used in the layout
    document.body.style.backgroundColor = "var(--color-blue-midnight)";
</script>

<Meta/>
<main class="h-auto xl:h-screen flex flex-col justify-between">
    <!-- Top maintence range -->
    <header class="w-full flex overflow-hidden">
        <div class="flex shrink-0">
            <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(0_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                Em Reforma
            </div>
            <div class="w-[10rem] bg-orange-amber py-1 px-4 -ml-[1.25rem] [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]">
            </div>
        </div>
        {#each Array(15) as _, index}
            <div class="flex -ml-[1.25rem] shrink-0">
                <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    Em Reforma
                </div>
                <div class="w-[10rem] bg-orange-amber py-1 px-4 -ml-[1.25rem] [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]">
                </div>
            </div>
        {/each}
    </header>

    <section>
        <div class="container-player">
            <div class="w-full flex justify-center mt-10">
                <img src="/img/default/logo_and_slogan.webp" alt="Logo" class="w-[20rem] lg:w-[30rem]"/>
            </div>
        </div>
        <Core/>
        <Dock/>
    </section>

    <!-- Bottom maintence range -->
    <footer class="w-full flex overflow-hidden rotate-180">
        <div class="flex shrink-0">
            <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(0_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                <span class="inline-block rotate-180">Em Reforma</span>
            </div>
            <div class="w-[10rem] bg-orange-amber py-1 px-4 -ml-[1.25rem] [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
        </div>
        {#each Array(15) as _, index}
            <div class="flex -ml-[1.25rem] shrink-0">
                <div class="bg-blue-ocean py-1 px-10 [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)] text-neutral-aurora font-noto-sans font-bold italic uppercase">
                    <span class="inline-block rotate-180">Em Reforma</span>
                </div>
                <div class="w-[10rem] bg-orange-amber py-1 px-4 -ml-[1.25rem] [clip-path:polygon(1.25rem_0,100%_0,calc(100%-1.25rem)_100%,0_100%)]"></div>
            </div>
        {/each}
    </footer>
</main>
