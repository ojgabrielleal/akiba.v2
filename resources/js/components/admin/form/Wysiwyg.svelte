<script>
  import { onMount } from 'svelte';
  import Quill from 'quill';

  let quill;
  let editor;
  let textarea;

  onMount(() => {
    quill = new Quill(editor, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ font: [] }, { size: [] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ color: [] }, { background: [] }],
          [{ script: 'sub' }, { script: 'super' }],
          [{ header: 1 }, { header: 2 }, 'blockquote', 'code-block'],
          [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
          [{ direction: 'rtl' }, { align: [] }],
          ['link', 'image', 'video', 'formula'],
          ['clean']
        ]
      }
    });

    // Atualiza o campo hidden quando o conteúdo muda
    quill.on('text-change', () => {
      textarea.value = quill.root.innerHTML;
    });
  });
</script>

<!-- Editor wrapper -->
<div class="bg-white rounded-xl overflow-hidden">
  <div bind:this={editor} class="min-h-[40rem] p-3" />
</div>

<!-- Campo hidden que será lido pelo FormData -->
<textarea name="content" class="hidden" bind:this={textarea}></textarea>

<style>
  @import 'quill/dist/quill.snow.css';
</style>
