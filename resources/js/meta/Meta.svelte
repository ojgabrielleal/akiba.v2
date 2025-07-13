<script>
  export let meta = {};

  const defaultTitle = 'Rede Akiba - O Paraíso dos Otakus! | Sua Melhor Fonte de Animes (e Mangás) no Brasil!';
  const defaultDescription = 'Rede Akiba é seu destino definitivo para animes, mangás, doramas e cultura otaku no Brasil.';
  const defaultKeywords = 'animes, mangás, otaku, cultura japonesa, doramas, rede akiba';

  $: fullTitle = meta.title ? `${meta.title} | Rede Akiba` : defaultTitle;
  $: metaDescription = meta.description || defaultDescription;
  $: metaKeywords = meta.keywords || defaultKeywords;
</script>

<svelte:head>
  <title>{fullTitle}</title>

  <!-- Meta padrão -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content={metaDescription} />
  <meta name="keywords" content={metaKeywords} />
  <meta name="author" content={meta.author || 'Rede Akiba'} />
  <meta name="theme-color" content={meta.themeColor || '#000000'} />
  <meta name="language" content="pt-BR" />
  <meta http-equiv="content-language" content="pt-br, en-us" />

  {#if meta.canonical}
    <link rel="canonical" href={meta.canonical} />
    <meta property="og:url" content={meta.canonical} />
  {/if}

  <!-- Open Graph -->
  <meta property="og:title" content={fullTitle} />
  <meta property="og:description" content={metaDescription} />
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="pt_BR" />
  {#if meta.ogImage}
    <meta property="og:image" content={meta.ogImage} />
  {/if}

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content={fullTitle} />
  <meta name="twitter:description" content={metaDescription} />
  {#if meta.ogImage}
    <meta name="twitter:image" content={meta.ogImage} />
  {/if}
</svelte:head>
