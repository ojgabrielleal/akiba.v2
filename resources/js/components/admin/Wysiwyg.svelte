<script>
    import { onMount } from "svelte";
    import Quill from "quill";
    import "quill/dist/quill.snow.css";

    export let value = "";   // 👈 já pode ser usado com bind:value
    export let height = "50rem";
    export let name = "content";

    let quill;
    let editor;
    let textarea;

    onMount(() => {
        quill = new Quill(editor, {
            theme: "snow",
            modules: {
                toolbar: [
                    [{ font: [] }, { size: [] }],
                    ["bold", "italic", "underline", "strike"],
                    [{ color: [] }, { background: [] }],
                    [{ script: "sub" }, { script: "super" }],
                    [{ header: 1 }, { header: 2 }, "blockquote", "code-block"],
                    [
                        { list: "ordered" },
                        { list: "bullet" },
                        { indent: "-1" },
                        { indent: "+1" },
                    ],
                    [{ direction: "rtl" }, { align: [] }],
                    ["link", "image", "video", "formula"],
                    ["clean"],
                ],
            },
        });

        // conteúdo inicial
        if (value) {
            quill.root.innerHTML = value;
            textarea.value = value;
        }

        // Atualiza o campo hidden E o bind:value
        quill.on("text-change", () => {
            value = quill.root.innerHTML;   // 👈 dispara reatividade
            textarea.value = value;
        });
    });

    // se a prop `value` mudar de fora → sincroniza com Quill
    $: if (quill && value !== quill.root.innerHTML) {
        quill.root.innerHTML = value;
        textarea.value = value;
    }
</script>

<div class="bg-neutral-aurora rounded-xl overflow-hidden">
    <div bind:this={editor} class="p-3 lg:min-h-[40rem]" style={`min-height: ${height};`}></div>
</div>
<textarea name={name} class="hidden" bind:this={textarea}></textarea>
