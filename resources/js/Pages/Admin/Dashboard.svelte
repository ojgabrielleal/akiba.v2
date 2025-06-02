<script>
    export let PropsUser;

    import { Meta } from "@/Meta";
    import { LayoutAdmin } from "@/Layouts";
    import { HeroGreating } from "@/Widgets/Hero";
    import { AlertCarrousel } from "@/Widgets/Alert";

    // Selector phrase in render to hero
    function phraseSwitchHero(apelido) {
        const phrases = [
            `Oi, ${apelido}!`,
            `E aí, ${apelido}?`,
            `Fala, ${apelido}!`,
            `Salve, ${apelido}!`,
            `Bom te ver, ${apelido}!`,
            `Bem-vindo(a), ${apelido}!`,
            `Tá na área, ${apelido}!`,
            `Chegou, ${apelido}!`,
            `De volta, ${apelido}?`,
            `Saudades, ${apelido}!`,
            `Você por aqui, ${apelido}?`,
            `${apelido}, firmeza?`,
            `Partiu, ${apelido}?`,
            `Na escuta, ${apelido}?`,
        ];

        const index = Math.floor(Math.random() * phrases.length);
        return phrases[index];
    }

    // Props to components
    let metatags = {
        title: "Dashboard",
    };

    const heroGreating = {
        phrase: phraseSwitchHero(PropsUser.nickname),
        icon: "/img/heroGreatingAvatar.png",
    };
</script>

<Meta meta={metatags} />
<LayoutAdmin {PropsUser}>
    <HeroGreating data={heroGreating} />
    <AlertCarrousel />
</LayoutAdmin>
