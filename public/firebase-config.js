// public/firebase-config.js

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyD-REPLACE-ME",
    authDomain: "realestateproject-ab701.firebaseapp.com",
    projectId: "realestateproject-ab701",
    storageBucket: "realestateproject-ab701.appspot.com",
    messagingSenderId: "378097822631",
    appId: "1:378097822631:web-REPLACE-ME"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

export { messaging, getToken, onMessage };
