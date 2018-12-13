/**
 * App Cache Update
 * Application Cache Update with Boostrap Modal integration
 * or Confirm if absents
 */

'use strict';

function askReboot() {
  var $modalTemplate = $('#modalTemplate');
  if ($modalTemplate.length) {
    var $modal = $modalTemplate;
    $modal.modal();
    $modal.find('.modal-body').text('Доступна нова версія Веб-додатку. Завантажити?');
    $modal.find('.btn-confrim').click(function () {
      window.location.reload();
    });
  } else if (confirm('Доступна нова версія Веб-додатку. Завантажити?')) {
    window.location.reload();
  }
}

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js'/*, { scope: './' }*/)
    .then(function (registration) {
      registration.addEventListener('updatefound', function () {
        // If updatefound is fired, it means that there's
        // a new service worker being installed.
        var installingWorker = registration.installing;
        console.info('A new service worker is being installed:',
          installingWorker);

        var serviceWorker;
        if (registration.installing) {
          serviceWorker = registration.installing;
          console.info('serviceWorker registration installing');
        } else if (registration.waiting) {
          serviceWorker = registration.waiting;
          console.info('serviceWorker registration waiting');
        } else if (registration.active) {
          serviceWorker = registration.active;
          console.info('serviceWorker registration active');
          askReboot();
        }

        if (serviceWorker) {
          console.info('serviceWorker state', serviceWorker.state);
          serviceWorker.addEventListener('statechange', function(e) {
            console.info('serviceWorker statechange', e.target.state);
          });
        }
      });
    })
    .catch(function (error) {
      console.error('Service worker registration failed:');
      console.error(error);
    });
} else {
  console.warn('Service workers are not supported.');
  if (window.applicationCache) {
    var ApplicationCacheEventMapEnum = {
      cached: 'cached', // Event
      checking: 'checking', // Event
      downloading: 'downloading', // Event
      error: 'error', // Event
      noupdate: 'noupdate', // Event
      obsolete: 'obsolete', // Event
      progress: 'progress', // ProgressEvent
      updateready: 'updateready', // Event
    };
    window.applicationCache.addEventListener(
      ApplicationCacheEventMapEnum.updateready,
      function (e) {
        if (
          window.applicationCache.status === window.applicationCache.UPDATEREADY
        ) {
          window.applicationCache.swapCache();
          var $modalTemplate = $('#modalTemplate');
          if ($modalTemplate.length) {
            var $modal = $modalTemplate;
            $modal.modal();
            $modal.find('.modal-body')
              .text('Доступна нова версія Веб-додатку. Завантажити?');
            $modal.find('.btn-confrim').click(function () {
              window.location.reload();
            });
          } else if (
            confirm('Доступна нова версія Веб-додатку. Завантажити?')
          ) {
            window.location.reload();
          }
        }
      },
      false
    );
  } else {
    console.warn('Application Cache is not supported.');
  }
}
