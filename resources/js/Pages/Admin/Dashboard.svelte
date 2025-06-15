<script>
    import { page } from "@inertiajs/svelte";

    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Greating } from "@/Widgets/Hero";
    import { Alerts} from "@/Widgets/Carrousel";

    let { user } = $page.props;

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
</script>

<Meta meta={{ title: "Dashboard" }} />
<Layout type="admin">
    <Greating
        phrase={phraseSwitchHero(user.nickname)}
        icon="/img/heroGreatingAvatar.png"
    />
    <Alerts />
</Layout>
