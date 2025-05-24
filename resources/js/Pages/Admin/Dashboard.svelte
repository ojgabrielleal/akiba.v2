<script>
    export let userdata;

    import { Meta } from "@/Meta";
    import { Layout } from "@/Layouts/Admin";
    import { HeroGreating } from "@/Components/HeroGreating";

    const metatags = {
        title: "Dashboard",
    };

    function heroGreating(apelido) {
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

<Meta meta={metatags} />
<Layout {userdata}>
    <HeroGreating phrase={heroGreating("Neko Kirame")} icon="/img/heroGreatingAvatar.png"/>
</Layout>
