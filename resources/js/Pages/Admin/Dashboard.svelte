<script>
    import { page } from "@inertiajs/svelte";
    
    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts";
    import { Greating } from "@/Widgets/Hero";
    import { Alerts, Tasks } from "@/Widgets/Carrousel";
    import { Posts } from "@/Widgets/Grid";
    import { Calendar } from "@/Widgets/Calendar";

    $:({ user } = $page.props); 

    // Selector phrase in render to hero
    function phraseSwitchHero(nickname) {
        const phrases = [
            `Konbanwa, ${nickname}!`,
            `Yaa~ ${nickname}!`,
            `Okaeri, ${nickname}!`,
            `Hehe~ ${nickname} chegou!`,
            `Hyaa~ ${nickname}!`,
            `Ohayou, ${nickname}!`,
            `${nickname}-senpai, notou?`,
            `Tadaima, ${nickname}?`,
            `Baka ${nickname}, demorou!`,
            `Uwaa~ é você, ${nickname}!`,
            `Yokoso, ${nickname}!`,
            `Genki ${nickname}?`,
            `Hora de brilhar, ${nickname}!`,
        ];
        const index = Math.floor(Math.random() * phrases.length);
        return phrases[index];
    }
</script>

<Meta meta={{ title: "Dashboard" }} />
<Layout type="admin">
    <Greating phrase={phraseSwitchHero(user.nickname)} icon="/img/heroGreatingAvatar.png"/>
    <Alerts title="Avisos para a equipe"/>
    <Tasks title="Minhas Tarefas"/>
    <Posts title="Últimas Matérias"/>
    <Calendar title="Calendário"/>
</Layout>
