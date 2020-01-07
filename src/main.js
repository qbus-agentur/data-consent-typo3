var consent = require('./index');

consent.isAccepted('essential').then(function(arg) {
	alert('Essential cookies have been enabled');
});
consent.isAccepted('marketing').then(function(arg) {
	alert(arg);
});

window.consent = consent;
