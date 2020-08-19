import firebase from 'firebase/app';
import 'firebase/database';
import 'firebase/auth'

const firebaseConfig = {

    apiKey: "AIzaSyBEmKQrRG2xY6js1xG_WJUecAbuav52EP0",
    authDomain: "simple-game-bc40b.firebaseapp.com",
    databaseURL: "https://simple-game-bc40b.firebaseio.com",
    projectId: "simple-game-bc40b",
    storageBucket: "simple-game-bc40b.appspot.com",
    messagingSenderId: "58580837783",
    appId: "1:58580837783:web:6ab0960c8e4f98730e50d2"

}

firebase.initializeApp(firebaseConfig)

const database = firebase.database()

export { database as default }
