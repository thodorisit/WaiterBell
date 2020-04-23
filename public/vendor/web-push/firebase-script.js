var firebaseConfig = {
    apiKey: "",
    authDomain: "",
    databaseURL: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: "",
    appId: "",
    measurementId: ""
};
firebase.initializeApp(firebaseConfig);
firebase.analytics();

const messaging = firebase.messaging();

messaging.requestPermission()
.then(function() {
    console.log('Notification permission granted.');
    messaging.getToken()
    .then(function(currentToken) {
        if (currentToken) {
            //console.log('Token: ' + currentToken);
            web_push_js.sendTokenToServer(currentToken);
        } else {
            console.log('No Instance ID token available. Request permission to generate one.');
            web_push_js.setTokenSentToServer(false);
        }
    })
    .catch(function(err) {
        console.log('An error occurred while retrieving token. ', err);
        web_push_js.setTokenSentToServer(false);
    });
})
.catch(function(err) {
    console.log('Unable to get permission to notify.', err);
});

messaging.onMessage(function(payload) {
    if (window.waiterbell_js_env.firebase_script_type_of_user == "employee") {
        window.menu_badge.increment();
    } else { //"business"
        window.ToastJS.create('success', payload.notification.title, payload.notification.body);
    }
    //console.log("Notification received: ", payload);
});

messaging.onTokenRefresh(function() {
    messaging.getToken()
    .then(function(refreshedToken) {
        console.log('Token refreshed.');
        web_push_js.setRefreshTokenSaveToServer(refreshedToken);
        web_push_js.setTokenSentToServer(false);
        window.sendTokenToServer(refreshedToken);
    })
    .catch(function(err) {
        console.log('Unable to retrieve refreshed token ', err);
    });
});

var web_push_js = {
    setRefreshTokenSaveToServer : function(refreshedToken) {
        if (!refreshedToken) {
            return false;
        }
        //Check if session's lifetime of 1 day has passed
        if (!window.cookiesHelper.read(window.waiterbell_js_env.cookie__last_page_action_timestamp)) {
            return false;
        }

        this.fillHiddenInputPushToken(refreshedToken);
        if (!web_push_js.isTokenSentToServer()) {
            var data = new FormData();
            data.append('_token', window.waiterbell_js_env.csrf_token);
            data.append('push_token', refreshedToken);
            data.append('reason', "refresh_token");
            var xhr = new XMLHttpRequest();
            xhr.open('POST', window.waiterbell_js_env.app_url+'/settings/update_push_token_action', true);
            xhr.onload = function(){
                var res = JSON.parse(this.response);
                if (res['success'] == 1) {
                    web_push_js.fillHiddenInputPushToken(refreshedToken);
                    web_push_js.setTokenSentToServer(true);
                } else {
                    console.log('Error: code A10062');
                }
            };
            xhr.onerror = function(){
                console.log('Error: code A10063');
            }
            xhr.send(data);
        } else {
            console.log('Token already sent to server so won\'t send it again ' +
                'unless it changes');
        }
    },
    sendTokenToServer : function(currentToken) {
        this.fillHiddenInputPushToken(currentToken);
    },
    revokeToken : function() {
    },
    fillHiddenInputPushToken : function(token) {
        if (document.getElementById(window.waiterbell_js_env.web_push_token_dom)) {
            document.getElementById(window.waiterbell_js_env.web_push_token_dom).value = token;
        }
    },
    setTokenSentToServer : function(sent) {
        window.localStorage.setItem('sentToServer', sent ? 1 : 0);
    },
    isTokenSentToServer : function () {
        return window.localStorage.getItem('sentToServer') == 1;
    }
};