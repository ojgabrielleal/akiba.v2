<script>
    import { page } from "@inertiajs/svelte";
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/private/";
    import { GreatingHero } from "@/widgets/private/hero";
    import { AlertsCarrousel, TasksCarrousel } from "@/widgets/private/carrousel";
    import { PublicationsGrid, CalendarGrid } from "@/widgets/private/grid";

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
    <!--
    <GreatingHero
        phrase={phraseSwitchHero(logged.nickname)}
        icon="/img/default/defaultHero.webp"
    />
    <AlertsCarrousel/>
    <TasksCarrousel />
    <PublicationsGrid
        title="Últimas Matérias"
        view="https://akiba.com.br/materias/"
        edit="/painel/materias/"
    />
    <CalendarGrid/>
    -->
</Layout>
