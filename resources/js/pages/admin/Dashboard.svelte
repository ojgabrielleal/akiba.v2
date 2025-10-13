<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin/";
    import { GreatingHero } from "@/widgets/admin/hero";
    import { AlertsCarrousel, TasksCarrousel } from "@/widgets/admin/carrousel";
    import { PublicationsGrid, CalendarGrid } from "@/widgets/admin/grid";

    $: ({ user } = $page.props);

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
    <GreatingHero
        phrase={phraseSwitchHero(user.nickname)}
        icon="/img/default/hero.webp"
    />
    <AlertsCarrousel/>
    <TasksCarrousel />
    <PublicationsGrid
        title="Últimas Matérias"
        view="https://akiba.com.br/materias/"
        edit="/painel/materias/"
    />
    <CalendarGrid/>
</Layout>
