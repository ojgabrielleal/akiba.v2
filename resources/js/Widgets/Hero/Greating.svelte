<script>
    import { page } from "@inertiajs/svelte";

    $:({ user } = $page.props); 

    // Selector phrase in render to hero
    function phraseSwitchHero(apelido) {
        const phrases = [
            `Konbanwa, ${apelido}!`,
            `Yaa~ ${apelido}!`,
            `Okaeri, ${apelido}!`,
            `Hehe~ ${apelido} chegou!`,
            `Hyaa~ ${apelido}!`,
            `Ohayou, ${apelido}!`,
            `${apelido}-senpai, notou?`,
            `Tadaima, ${apelido}?`,
            `Baka ${apelido}, demorou!`,
            `Uwaa~ é você, ${apelido}!`,
            `Yokoso, ${apelido}!`,
            `Genki ${apelido}?`,
            `Hora de brilhar, ${apelido}!`,
        ];
        const index = Math.floor(Math.random() * phrases.length);
        return phrases[index];
    }
</script>


<section class="w-full mt-10 lg:mt-20 mb-20">
    <div class="w-full bg-[var(--color-blue-ocean)] h-full mx-auto relative rounded-xl py-4 lg:w-1/2 lg:h-[3.8rem] lg:py-0">
        <img src="/img/heroGreatingAvatar.png" alt="Avatar da Frase" class="w-[6.7rem] absolute bottom-0 hidden lg:block"/>
        <span class="w-3/5 h-full flex items-center justify-center mx-auto font-noto-sans font-black italic text-sm text-[var(--color-neutral-aurora)] xl:text-2xl">
            {phraseSwitchHero(user.nickname)}
        </span>
    </div>
</section>
