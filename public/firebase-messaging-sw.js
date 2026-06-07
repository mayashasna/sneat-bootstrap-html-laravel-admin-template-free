// Firebase SW (Compat)
importScripts('https://www.gstatic.com/firebasejs/9.6.11/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.11/firebase-messaging-compat.js');

// Initialize Firebase
firebase.initializeApp({
    apiKey: "AIzaSyCfL-8rPe0rGB4GlqPTS3kTipWHaiEmjBM",
    authDomain: "realestateproject-ab701.firebaseapp.com",
    projectId: "realestateproject-ab701",
    storageBucket: "realestateproject-ab701.appspot.com",
    messagingSenderId: "378097822631",
    appId: "1:378097822631:web:7654edb4b08135d8d02482",
    measurementId: "G-9BBKN8ZQJX"
});

// Messaging instance
const messaging = firebase.messaging();

// Background notifications
messaging.onBackgroundMessage(function(payload) {
    console.log("Received background message ", payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || "/logo.png"
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

// ⭐⭐ الخطوة 3 — إضافة RAW PUSH EVENT DEBUG ⭐⭐
self.addEventListener('push', event => {
    console.log("🔥 RAW PUSH EVENT:", event);
});
