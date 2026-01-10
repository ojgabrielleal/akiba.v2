<script>
    import { page, Link } from "@inertiajs/svelte";
    import { CanRender } from "@/components/private/";
    import navbarJson from "@/data/navbar.json";

    $: ({ logged } = $page.props);

    let mobilenavbar = false;
</script>


<nav class="w-full h-[3rem] bg-neutral-aurora hidden items-center justify-center lg:flex">
    <div class="container relative">
        <ul class="flex justify-center items-center gap-10">
        {#each navbarJson as item}
            <CanRender permission={item.permission}>
                <li>
                    <Link href={item.address} aria-label={item.name} class="flex items-center gap-2 text-neutral-aurora">
                        <img src={item.icon} alt="" aria-hidden="true" class="w-5 h-5" loading="lazy"/>
                    </Link>
                </li>
            </CanRender>
        {/each}
        </ul>
        <div class="absolute -bottom-[1.45rem] right-0 flex items-center gap-2">
            <Link href={`/painel/profile/${logged.slug}`} aria-label={logged.nickname}>
                <img src={logged.avatar} alt={`Avatar de ${logged.nickname}`} class="w-16 h-16 rounded-full object-cover object-top border-8 border-neutral-aurora" loading="lazy"/>
            </Link>
        </div>
    </div>
</nav>

<!-- Mobile Navbar -->
<nav class="w-full h-[4rem] bg-neutral-aurora flex items-center justify-between px-10 lg:hidden">
    <button on:click={() => (mobilenavbar = !mobilenavbar)} aria-label="Abrir menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <img src={logged.avatar} alt={`Avatar de ${logged.nickname}`} class="w-10 h-10 rounded-full object-cover object-top" loading="lazy"/>
</nav>

<!-- Sidebar Menu -->
<div class={['fixed top-0 left-0 h-full w-64 bg-neutral-aurora z-50 shadow-md transform transition-transform duration-300', 
    {'translate-x-0': mobilenavbar},
    {'-translate-x-full': !mobilenavbar}
]}>
    <div class="p-5 flex items-center justify-between">
        <img src="/favicon.ico" alt="Logo" class="w-8 h-8" loading="lazy"/>
        <button on:click={() => (mobilenavbar = false)} aria-label="Fechar menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    
    <ul class="p-5 pt-3 space-y-4">
        {#each navbarJson as item}
            <CanRender permission={item.permission}>
                <li>
                    <Link href={item.address} aria-label={item.name} class="flex items-center gap-3 text-gray-800 hover:text-blue-600">
                        <img src={item.icon} alt="" aria-hidden="true" class="w-5 h-5" loading="lazy"/>
                        <span>{item.name}</span>
                    </Link>
                </li>
            </CanRender>
        {/each}
    </ul>
</div>
