<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { Offcanvas } from "@/components/admin";
    import { ShowForm } from "@/widgets/admin/form"
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <Offcanvas>
        <div slot="action" class="flex justify-center">
            <span class="block cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
                Cadastrar programa
            </span>
        </div>
        <h1 slot="title">
            Novo programa
        </h1>
        <div slot="content" let:close>
            <ShowForm {close}/>
        </div>
    </Offcanvas>
</Layout>
