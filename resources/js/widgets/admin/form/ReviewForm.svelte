<script>
    import { page } from "@inertiajs/svelte";
    import { Preview, Wysiwyg } from "@/components/admin";

    $:({ user, review } = $page.props);

</script>

<form on:submit={onSubmit}>
    <div class="grid grid-cols-1 xl:grid-cols-[22rem_1fr] gap-5">
        <div class="mb-3">
            <span class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1">
                Imagem em destaque
            </span>
            <Preview name="image" value={review?.image}/>
        </div>
        <div class="mb-3">
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="title">
                    Título
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full h-[3rem] bg-neutral-aurora font-noto-sans rounded-lg outline-none pl-4"
                    value={review?.title}
                />
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="sinopse">
                    Sinopse do anime
                </label>
                <Wysiwyg height="15rem" name="sinopse" value={review?.sinopse}/>
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="cover">
                    Capa do review
                </label>
                <Preview name="cover"  value={review?.cover}/>
            </div>
            <div class="mb-8">
                <label class="text-orange-amber font-bold italic text-lg uppercase font-noto-sans block mb-1" for="content">
                    Escreva o review
                </label>
                {#if review?.authors}
                    <div class="flex mb-3 mt-2">
                        {#each review?.authors as author}
                            <button aria-label={author.nickname} class="bg-neutral-aurora py-2 px-6 rounded-sm text-orange-amber uppercase flex justify-center items-center font-noto-sans italic font-bold cursor-pointer">
                                {author.nickname}
                            </button>
                        {/each}
                    </div>
                {/if}
                <Wysiwyg name="content"/>
            </div>
        </div>
    </div>
</form>
