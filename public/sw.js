// Apenas registra o service worker
self.addEventListener('install', event => {
  console.log('Service Worker instalado');
});

self.addEventListener('fetch', event => {
  // Apenas deixa todas as requisições passarem
  event.respondWith(fetch(event.request));
});

self.addEventListener('activate', event => {
  console.log('Service Worker ativado');
});