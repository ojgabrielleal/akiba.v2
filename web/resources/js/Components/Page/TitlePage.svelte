<script>
  export let title = null
  const defaultTitle = 'Rede Akiba - O Paraíso dos Otakus! | Sua Melhor Fonte de Animes (e Mangás) no Brasil!'
  $: fullTitle = title ? `${title} | ${defaultTitle}` : defaultTitle
</script>

<svelte:head>
  <title>{fullTitle}</title>
</svelte:head>
