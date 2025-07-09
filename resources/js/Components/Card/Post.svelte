<script>
    export let data = {};
    export let editable = false;
    export let color = "bg-[var(--color-blue-skywave)]";

    import { Link } from "@inertiajs/svelte";

    import { Edit, View} from "@/Components/Button";
</script>

<div class={`${color} w-full h-[14rem] flex-shrink-0 rounded-lg p-4 relative lg:w-[18.2rem]`}>
    <span class="font-noto-sans text-lg text-[var(--color-neutral-aurora)] line-clamp-5 uppercase">
        {data.title}
    </span>
    <div class="flex justify-between gap-5 absolute bottom-2 left-4 w-[calc(100%-2rem)]">
        <span class="font-noto-sans font-bold italic uppercase text-lg text-[var(--color-neutral-aurora)]">
            {data.user.nickname}
        </span>
        <div class="flex gap-1">
            <Link href={`https://akiba.com.br/materias/${data.slug}`}>
                <View/>
            </Link>
            {#if editable}
                <Link href={`/painel/materias/${data.slug}`}>
                    <Edit/>
                </Link>
            {/if}
        </div>
    </div>
</div>