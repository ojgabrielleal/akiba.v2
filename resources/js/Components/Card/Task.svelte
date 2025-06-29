<script>
    export let late = false;
    
    import { Confirm, Danger } from "@/Components/Button"

    $: colors = late ? "bg-[var(--color-orange-amber)]" : "bg-[var(--color-blue-skywave)]";
</script>

{#if late}
    <div class={`${colors} w-[40rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            Tarefa teste
        </h1>
        <p class="w-90 ont-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales quis turpis 
            ac auctor. Nullam consectetur mollis ex id aliquam. Nulla eget aliquam ante. Nullam 
            diam tortor, aliquet eget sapien ut, faucibus commodo diam. Pellentesque tristique 
            lorem a facilisis ultricies. Nunc quis diam facilisis diam rutrum aliquet. Vestibulum 
            maximus luctus arcu, sed ultrices urna gravida eget. Pellentesque tempor commodo nibh 
            non aliquam. Pellentesque interdum mi metus, nec luctus ipsum hendrerit sit amet. Integer 
            ullamcorper nunc a pharetra egestas.
        </p>
        <div class="absolute top-5 right-5 bg-[var(--color-blue-indigo)] rounded-xl shadow-lg w-[7rem] text-center overflow-hidden">
            <div class="bg-[var(--color-red-crimson)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-neutral-aurora)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                24/08
            </div>
        </div>
        <Danger styles="absolute right-5 bottom-3"/>
    </div>
{:else}
    <div class={`${colors} w-[35rem] lg:h-43 flex-shrink-0 rounded-lg p-4 relative`}>
        <h1 class="uppercase font-noto-sans text-[var(--color-neutral-aurora)] italic font-bold text-2xl">
            Tarefa teste
        </h1>
        <p class="w-90 ont-noto-sans text-sm text-[var(--color-neutral-aurora)] line-clamp-5 mt-1">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales quis turpis 
            ac auctor. Nullam consectetur mollis ex id aliquam. Nulla eget aliquam ante. Nullam 
            diam tortor, aliquet eget sapien ut, faucibus commodo diam. Pellentesque tristique 
            lorem a facilisis ultricies. Nunc quis diam facilisis diam rutrum aliquet. Vestibulum 
            maximus luctus arcu, sed ultrices urna gravida eget. Pellentesque tempor commodo nibh 
            non aliquam. Pellentesque interdum mi metus, nec luctus ipsum hendrerit sit amet. Integer 
            ullamcorper nunc a pharetra egestas.
        </p>
        <div class="absolute top-5 right-5 bg-[var(--color-neutral-aurora)] rounded-xl shadow-lg w-[7rem] text-center overflow-hidden">
            <div class="bg-[var(--color-blue-indigo)] text-[var(--color-neutral-aurora)] font-noto-sans italic font-bold text-sm py-1 tracking-wide uppercase">
                Data Limite
            </div>
            <div class="text-[var(--color-blue-indigo)] font-noto-sans italic font-extrabold text-2xl py-1 tracking-widest">
                24/08
            </div>
        </div>
        <Confirm styles="absolute right-5 bottom-3"/>
    </div>
{/if}
