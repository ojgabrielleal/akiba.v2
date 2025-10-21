<script>
    import { Meta } from "@/meta";
    import { CorePlayer, DockPlayer } from "@/widgets/public/player"
    import { metadata } from "@/store" 

    document.body.style.backgroundColor = "var(--color-blue-midnight)";
    document.body.style.overflowX = "hidden";
</script>

<Meta/>
<header>
    <article class="w-full flex overflow-hidden fixed top-0 z-10">            
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
    </article>
</header>
<main class="mt-23 h-auto">
    <div class="container">
        <div class="w-full flex justify-center">
            <img src="/img/default/logo_and_slogan.webp" alt="Logo" class="w-[20rem] lg:w-[30rem]" loading="lazy"/>
        </div>
    </div>
    <CorePlayer/>
</main>
<footer>
    <DockPlayer/>
    <article class="w-full flex overflow-hidden rotate-180 fixed bottom-0 z-10">
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
    </article>
</footer>
