<script>
    export let phrase = null;
    export let icon = null;
</script>

<section class="w-full mb-10 lg:mt-20 lg:mb-20">
    <div class="w-full bg-blue-ocean h-full mx-auto relative rounded-xl py-4 lg:w-1/2 lg:h-[3.8rem] lg:py-0">
        {#if icon}
            <img src={icon} alt="" aria-hidden="true" class="w-[6.7rem] absolute bottom-0 hidden lg:block" loading="lazy"/>
        {/if}
        <div class="w-3/5 h-full flex items-center justify-center mx-auto font-noto-sans font-black italic text-sm text-neutral-aurora xl:text-2xl">
            {phrase}
        </div>
    </div>
</section>
