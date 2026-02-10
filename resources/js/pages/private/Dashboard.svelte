<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/config/meta";
    import { Layout } from "@/layouts/private/";
    import { GreatingHero } from "@/ui/widgets/private/hero";
    import { ActivitiesCarrousel, TasksCarrousel } from "@/ui/widgets/private/carrousel";
    import { PostsGrid, CalendarGrid } from "@/ui/widgets/private/grid";
    import { hasPermissions } from "@/utils";

    $: ({ 
        user,
        activities,
        tasks,
        posts,
        calendar
    } = $page.props);

    $: authorization = {
        canViewActivities: hasPermissions(user, 'activity.list'),
        canViewTasks: hasPermissions(user, 'task.list'),
        canViewPublications: hasPermissions(user, 'post.list'),
        canViewCalendar: hasPermissions(user, 'calendar.list')
    }

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
    <GreatingHero phrase={phraseSwitchHero(user.nickname)} icon="/img/default/avatar.webp"/>
    {#if authorization.canViewActivities}
        <ActivitiesCarrousel 
            title="Avisos e Atividades"
            {activities}
            {user}
        />
    {/if}
    {#if authorization.canViewTasks}
        <TasksCarrousel 
            title="Minhas Tarefas"
            {tasks}
            {user}
        />
    {/if}
    {#if authorization.canViewPublications}
        <PostsGrid 
            title="Últimas Matérias" 
            {posts}
            {user}
        />
    {/if}
    {#if authorization.canViewCalendar}
        <CalendarGrid 
            title="Calendário"
            {calendar}
            {user}
        />
    {/if}
</Layout>
