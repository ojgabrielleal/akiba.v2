<script>
    import { page } from "@inertiajs/svelte";
    
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin/";
    import { GreatingHero } from "@/widgets/admin/hero";
    import { AlertsCarrousel, TasksCarrousel } from "@/widgets/admin/carrousel";
    import { PublicationsGrid, CalendarGrid } from "@/widgets/admin/grid";

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
<Layout>
    <GreatingHero phrase={phraseSwitchHero(user.nickname)} icon="/img/heroGreatingAvatar.png"/>
    <AlertsCarrousel title="Avisos para a equipe"/>
    <TasksCarrousel title="Minhas Tarefas"/>
    <PublicationsGrid title="Últimas Matérias" view="https://akiba.com.br/materias/" edit="/painel/materias/"/>
    <CalendarGrid title="Calendário"/>
</Layout>
