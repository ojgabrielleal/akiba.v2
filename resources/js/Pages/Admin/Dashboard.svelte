<script>
    export let userdata;

    import { Meta } from '@/Meta';
    import { Layout } from '@/Layouts/Admin';
    import { Navbar } from '@/Components/Navbar/Admin';

    const metatags = {
        title: 'Dashboard',
    }
</script>

<Meta meta={metatags} />
<Layout>
    <Navbar slot="header" userdata={userdata}/>
</Layout>
