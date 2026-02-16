<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private/";
    import { GreatingHero } from "@/ui/widgets/private/hero";
    import { ActivitiesCarrousel, TasksCarrousel } from "@/ui/widgets/private/carrousel";
    import { PostsGrid, CalendarGrid } from "@/ui/widgets/private/grid";

    $: ({ 
        authenticated: { user },
    } = $page.props);

     const phraseSwitchHero = (nickname) => {
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
    <GreatingHero phrase={phraseSwitchHero(user.nickname)} icon="/img/default/avatar.webp"/>
    <ActivitiesCarrousel title="Avisos e Atividades" />
    <TasksCarrousel title="Minhas Tarefas"/>
    <PostsGrid title="Últimas Matérias"  />
    <CalendarGrid title="Calendário" />
</Layout>
