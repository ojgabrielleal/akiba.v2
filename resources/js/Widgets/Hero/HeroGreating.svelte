<script>
    export let data = {}

    let permanent = { 
        phrase: "Olá, qual é a boa?",
        icon: "/img/heroGreatingAvatar.png"
    }

    $: merge = { 
        phrase: data.phrase ?? permanent.phrase,
        icon: data.icon ?? permanent.icon,
    }
</script>


<section class="w-full mt-10 lg:mt-20">
    <div class="w-full bg-[var(--color-blue-ocean)] h-full mx-auto relative rounded-xl py-4 lg:w-1/2 lg:h-[3.8rem] lg:py-0">
        {#if merge.icon}
            <img src={merge.icon} alt="Avatar da Frase" class="w-[6.7rem] absolute bottom-0 hidden lg:block"/>
        {/if}
        <span class="w-3/5 h-full flex items-center justify-center mx-auto font-noto-sans font-black italic text-sm text-[var(--color-neutral-aurora)] xl:text-2xl">
            {merge.phrase}
        </span>
    </div>
</section>