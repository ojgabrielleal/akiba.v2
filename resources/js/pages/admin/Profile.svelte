<script>
    import { page } from "@inertiajs/svelte"
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { ProfileForm } from "@/widgets/admin/form";

     $: ({ profile } = $page.props);

     $: titleAdapted = `Perfil ${profile?.gender === "male" ? "do" : "da"} ${profile?.nickname}`
</script>

<Meta meta={{ title: titleAdapted }} />
<Layout>
    <ProfileForm/>
</Layout>