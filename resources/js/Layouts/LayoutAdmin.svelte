<script> 
    export let PropsUser;

    import { Toaster } from "svelte-hot-french-toast";    
    import { NavAdmin } from '@/Widgets/Navbar';

    // Props to components
    let navbar = { 
      user: PropsUser,
      items: [
        { name: "Dashboard", icon: "/icons/dashboard.svg", permissions: ["administrator", "all"], address: "/painel/dashboard"},
        { name: "Materias", icon: "/icons/materials.svg", permissions: ["administrator", "writer"], address: "/painel/materials"},
        { name: "Locução", icon: "/icons/broadcast.svg", permissions: ["administrator", "broadcaster"], address: "/painel/broadcast"},
        { name: "Rádio", icon: "/icons/radio.svg", permissions: ["administrator"], address: "/painel/radio"},
        { name: "Podcasts", icon: "/icons/podcasts.svg", permissions: ["administrator"], address: "/painel/podcasts"},
        { name: "Marketing", icon: "/icons/marketing.svg", permissions: ["administrator", "marketing"], address: "/painel/marketing"},
        { name: "Mídias", icon: "/icons/media.svg", permissions: ["administrator", "marketing"], address: "/painel/media"},
        { name: "Administração", icon: "/icons/adms.svg", permissions: ["administrator"], address: "/painel/administrator"},
        { name: "Logs", icon: "/icons/logs.svg", permissions: ["administrator"], address: "/painel/logs"},
        { name: "Avisos", icon: "/icons/alerts.svg", permissions: ["administrator", "all"], address: "/painel/alerts"}
      ]
    }
</script>

<Toaster/>
<div class="w-screen bg-[var(--color-blue-indigo)]">
  <header class="lg:pt-10">
    <NavAdmin data={navbar} />
    <slot name="header" />
  </header>

  <!-- Conteúdo principal -->
  <main class="container">
    <slot />
  </main>
</div>