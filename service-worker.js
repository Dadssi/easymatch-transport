const CACHE_NAME = 'easyMatch-cache-v1';
const urlsToCache = [
  '/',
  'app/views/home.view.php',
  'public/assets/css/style.css',
  'public/assets/js/main.js',
  'public/assets/img/logo-easymatch.png',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', (event) => {
  const requestUrl = new URL(event.request.url);
  
  // Si l'URL commence par '/dynamic/', appliquez une logique de mise en cache différente
  if (requestUrl.pathname.startsWith('/dynamic/')) {
    event.respondWith(
      caches.match(event.request)
        .then((cachedResponse) => {
          const fetchPromise = fetch(event.request)
            .then((fetchResponse) => {
              return caches.open(CACHE_NAME)
                .then((cache) => {
                  cache.put(event.request, fetchResponse.clone());
                  return fetchResponse;
                });
            });
          return cachedResponse || fetchPromise;
        })
    );
  } else {
    // Pour les autres requêtes, utilisez la logique standard de mise en cache
    event.respondWith(
      caches.match(event.request)
        .then((response) => {
          return response || fetch(event.request)
            .then((fetchResponse) => {
              return caches.open(CACHE_NAME)
                .then((cache) => {
                  cache.put(event.request, fetchResponse.clone());
                  return fetchResponse;
                });
            });
        })
    );
  }
});
