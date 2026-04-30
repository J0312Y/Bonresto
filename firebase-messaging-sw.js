importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.17.1/firebase-messaging.js');

// Configuration Firebase
var config = {
    apiKey: "AIzaSyAmQ43V5XgOtd9Yd_wo-FROpkQ3tWLqcX0",
    authDomain: "my-apps-project-9ba31.firebaseapp.com",
    databaseURL: "https://my-apps-project-9ba31.firebaseio.com",
    projectId: "my-apps-project-9ba31",
    storageBucket: "my-apps-project-9ba31.appspot.com",
    messagingSenderId: "562824560989",
    appId: "1:562824560989:web:7f068c5adbf5436210e8b4"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

// Détection automatique de l'environnement
const isLocalhost = self.location.hostname === "localhost" || self.location.hostname === "127.0.0.1";
const BASE_URL = isLocalhost ? "http://localhost" : self.location.origin;

// Définition des icônes par défaut
const defaultIcon = `${BASE_URL}/img/icon.png`;
const defaultImage = `${BASE_URL}/img/d.png`;

// Gestion des messages en arrière-plan
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message', payload);

    const notificationTitle = payload.data?.title || 'Nouvelle notification';
    const notificationOptions = {
        body: payload.data?.body || '',
        icon: payload.data?.icon || defaultIcon,
        image: payload.data?.image || defaultImage,
        data: {
            url: payload.data?.click_action || '/'
        }
    };

    // Retour de la promesse pour éviter l'erreur de canal fermé
    return self.registration.showNotification(notificationTitle, notificationOptions)
        .then(() => {
            console.log('Notification affichée avec succès.');
        })
        .catch(err => {
            console.error('Erreur lors de l’affichage de la notification:', err);
        });
});

// Gestion du clic sur la notification
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const clickUrl = event.notification.data?.url || '/';
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            for (const client of clientList) {
                if (client.url === clickUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(clickUrl);
            }
        })
    );
});
