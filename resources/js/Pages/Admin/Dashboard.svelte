<script>
    export let userdata;

    import { Meta } from '@/Meta';
    import { Layout } from '@/Layouts/Admin';

    const metatags = {
        title: 'Dashboard',
    }
</script>

<Meta meta={metatags} />
<Layout userdata={userdata}>
</Layout>
