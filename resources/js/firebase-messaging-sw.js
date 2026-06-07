import { copyFileSync } from 'fs';

function copyServiceWorker() {
  return {
    name: 'copy-sw',
    closeBundle() {
      try {
        copyFileSync(
          'resources/js/firebase-messaging-sw.js',
          'public/firebase-messaging-sw.js'
        );
        console.log('Service Worker copied successfully');
      } catch (error) {
        console.error('Failed to copy Service Worker:', error);
      }
    }
  };
}

export default copyServiceWorker;
