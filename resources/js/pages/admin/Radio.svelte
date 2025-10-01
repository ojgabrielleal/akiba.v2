<script>
    import { Meta } from "@/meta";
    import { Layout } from "@/layouts/admin";
    import { Modal } from "@/components/admin";
</script>

<Meta meta={{ title: "Rádio" }} />
<Layout>
    <Modal>
        <div slot="action" class="flex justify-center">
            <span class="block cursor-pointer bg-blue-skywave px-8 py-2 rounded-md text-neutral-aurora font-noto-sans font-bold italic uppercase">
                Cadastrar programa
            </span>
        </div>
        <h1 slot="title" class="text-neutral-aurora font-noto-sans font-bold italic uppercase">
            Novo programa
        </h1>
        <div slot="content">
            teste
        </div>
    </Modal>
</Layout>
