var consent = require('./index');

consent.isAccepted().then(function(state) {
        alert(JSON.stringify(state));
});
consent.isAccepted('essential').then(function(type) {
	alert('Essential cookies have been enabled');
});
consent.isAccepted('marketing').then(function(state) {
	alert('marketing is enabled, state: ' . JSON.stringify(state));
});

window.consent = consent;
