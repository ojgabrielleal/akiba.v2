<script>
    export let data = {};
    
    import { Link } from '@inertiajs/svelte';
    
    let permanent = { 
        user: {
            "name": "Não Identificado",
            "nickname": "Não Identificado San",
            "avatar": ""
        },
        permissions: ["all"],
        items: [
            { name: "Dashboard", icon: "/icons/dashboard.svg", permissions: ["administrator", "all"], address: "/painel/dashboard" },
            { name: "Materias", icon: "/icons/materials.svg", permissions: ["administrator", "writer"], address: "/painel/materials" },
            { name: "Locução", icon: "/icons/broadcast.svg", permissions: ["administrator", "broadcaster"], address: "/painel/broadcast" },
            { name: "Rádio", icon: "/icons/radio.svg", permissions: ["administrator"], address: "/painel/radio" },
            { name: "Podcasts", icon: "/icons/podcasts.svg", permissions: ["administrator"], address: "/painel/podcasts" },
            { name: "Marketing", icon: "/icons/marketing.svg", permissions: ["administrator", "marketing"], address: "/painel/marketing" },
            { name: "Mídias", icon: "/icons/media.svg", permissions: ["administrator", "marketing"], address: "/painel/media" },
            { name: "Administração", icon: "/icons/adms.svg", permissions: ["administrator"], address: "/painel/administrator" },
            { name: "Logs", icon: "/icons/logs.svg", permissions: ["administrator"], address: "/painel/logs" },
            { name: "Avisos", icon: "/icons/alerts.svg", permissions: ["administrator", "all"], address: "/painel/alerts" }
        ]
    };

    $: merge = { 
        user: data.user ?? permanent.user,
        permissions: data.user.permissions.lenght > 0 ? data.user.permissions : permanent.permissions,
        items: data.items ?? permanent.items
    }

    // Open the navbar in mobile
    let mobilenavbar = false;
</script>


<nav class="w-full h-[3rem] bg-[var(--color-neutral-aurora)] hidden items-center justify-center lg:flex">
    <div class="container relative">
        <ul class="flex justify-center items-center gap-10">
        {#each merge.items as item}
            {#if item.permissions?.some(p => merge.permissions?.includes(p))}
                <li>
                    <Link href={item.address} title={item.name} class="flex items-center gap-2 text-[var(--color-neutral-aurora)] hover:text-[var(--color-neutral-aurora-dark)]">
                        <img src={item.icon} alt={item.name} class="w-5 h-5" />
                    </Link>
                </li>
            {/if}
        {/each}
        </ul>
        <div class="absolute -bottom-[1.45rem] right-0 flex items-center gap-2">
            <Link href={`/profile/${merge.user.slug}`} title={merge.user.nickname}>
                <img
                    src={merge.user.avatar}
                    alt={merge.user.nickname}
                    class="w-16 h-16 rounded-full border-8 border-[var(--color-neutral-aurora)]"
                />
            </Link>
        </div>
    </div>
</nav>


<!-- Mobile Navbar -->
<nav class="w-full h-[4rem] bg-[var(--color-neutral-aurora)] flex items-center justify-between px-10 lg:hidden">
    <button on:click={() => (mobilenavbar = !mobilenavbar)} aria-label="Abrir menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <img src={merge.user.avatar} alt={merge.user.nickname} class="w-10 h-10 rounded-full"/>
</nav>

<!-- Sidebar Menu -->
<div class={`fixed top-0 left-0 h-full w-64 bg-[var(--color-neutral-aurora)] z-50 shadow-md transform transition-transform duration-300 ${mobilenavbar ? 'translate-x-0' : '-translate-x-full'}`}>
    <div class="p-5 flex items-center justify-between">
        <img src="/favicon.ico" alt="Logo" class="w-8 h-8"/>
        <button on:click={() => (openmobile = false)} aria-label="Fechar menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <ul class="p-5 pt-3 space-y-4">
        {#each merge.items as item}
            {#if item.permissions?.some(p => merge.permissions.includes(p))}
                <li>
                    <a href={item.address} class="flex items-center gap-3 text-gray-800 hover:text-blue-600">
                        <img src={item.icon} alt={item.name} class="w-5 h-5" />
                        <span>{item.name}</span>
                    </a>
                </li>
            {/if}
        {/each}
    </ul>
</div>
