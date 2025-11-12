// firebase-messaging-sw.js

// Import Firebase scripts
importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-messaging.js');

// 🔹 Configure Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCm2qFBF085Y9hPLr7BmKJBxQx_wWqwIAE",
    authDomain: "restaurantqrapp-ea222.firebaseapp.com",
    databaseURL: "https://restaurantqrapp-ea222-default-rtdb.firebaseio.com",
    projectId: "restaurantqrapp-ea222",
    storageBucket: "restaurantqrapp-ea222.firebasestorage.app",
    messagingSenderId: "772898595253",
    appId: "1:772898595253:web:7c182c663e7327938579fc",
    measurementId: "G-M6WZJTBZWC"
};

// ✅ Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message:', payload);

    // Customize notification
    const notificationTitle = payload.data.title || 'New Notification';
    const notificationOptions = {
        body: payload.data.body || 'You have a new message.',
        icon: payload.data.icon || '/Bonresto/assets/images/icon.png',
        image: payload.data.image || '/Bonresto/assets/images/notification.png'
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Optional: handle notification click
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow('/') // Open homepage or specific page
    );
});
/* ===============================
   🔹 Firebase Cloud Messaging
================================ */