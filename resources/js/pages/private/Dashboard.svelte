<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private/";
    import { CanRender } from "@/ui/components/private/";
    import { GreatingHero } from "@/ui/widgets/private/hero";
    import { ActivitiesCarrousel, TasksCarrousel } from "@/ui/widgets/private/carrousel";
    import { PublicationsGrid, CalendarGrid } from "@/ui/widgets/private/grid";

    $: ({ logged } = $page.props);

    function phraseSwitchHero(nickname) {
        const phrases = [
            `Oi, ${nickname}! Que bom te ver.`,
            `Bem-vindo(a) de volta, ${nickname}!`,
            `Que bom que você chegou, ${nickname}!`,
            `Ei, ${nickname}!`,
            `Saudades, ${nickname}!`,
            `Chegou agora, ${nickname}?`,
            `${nickname}, demorou um pouco, hein!`,
            `Ah, é você, ${nickname}!`,
            `Seja bem-vindo(a), ${nickname}!`,
            `${nickname}, como você está?`,
            `Hora de começar, ${nickname}!`,
        ];
        const index = Math.floor(Math.random() * phrases.length);
        return phrases[index];
    }
</script>

<Meta meta={{ title: "Dashboard" }} />
<Layout>
    <GreatingHero phrase={phraseSwitchHero(logged.nickname)} icon="/img/default/defaultHero.webp"/>
    <CanRender permission="activity.list">
        <ActivitiesCarrousel title="Avisos e Atividades"/>
    </CanRender>
    <CanRender permission="task.list">
        <TasksCarrousel title="Minhas Tarefas"/>
    </CanRender>
    <CanRender permission="post.list">
        <PublicationsGrid title="Últimas Matérias" type="materias"/>
    </CanRender>
    <CanRender permission="calendar.list">
        <CalendarGrid title="Calendário"/>
    </CanRender>
</Layout>
