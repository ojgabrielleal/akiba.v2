<script>
    import { Preview, Label, Input } from '@/components/admin/form';
</script>

<form class="grid grid-cols-1 lg:grid-cols-[22rem_1fr] gap-5">
    <div class="mb-3">
        <Label name="image">Imagem em destaque</Label>
        <Preview name="image" />
    </div>
    <div class="mb-3">
        <div class="mb-8">
            <Label name="title">Título</Label>
            <Input name="title"/>
        </div>
        <div class="mb-8">
            <Label name="cover">Capa da matéria</Label>
            <Preview name="cover" previewHeight="max-h-[30rem]"/>
        </div>
    </div>
</form>