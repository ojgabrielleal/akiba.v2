<script>
    import { page } from "@inertiajs/svelte";

    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Greating } from "@/Widgets/Hero";
    import { Alerts, Tasks } from "@/Widgets/Carrousel";

    $:({ user, alerts } = $page.props);

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

<Meta meta={{ title: "Dashboard" }} />
<Layout type="admin">
    <Greating phrase={phraseSwitchHero(user.nickname)}  icon="/img/heroGreatingAvatar.png"/>
    <Alerts title="Avisos para a equipe" data={alerts}/>
    <Tasks title="Minhas Tarefas"/>
</Layout>
