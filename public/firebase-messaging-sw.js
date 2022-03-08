// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBPvLFD_SXfrYaSx7Kicdu2G0iYDNIiyLw",
    authDomain: "allied-fcm.firebaseapp.com",
    projectId: "allied-fcm",
    storageBucket: "allied-fcm.appspot.com",
    messagingSenderId: "437743599244",
    appId: "1:437743599244:web:149ff381e30c61a12645a9",
    measurementId: "G-2XEBSMLK76",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
