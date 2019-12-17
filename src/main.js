var consent = require('./index');

consent.isAccepted('youtube').then(function(arg) {
	alert(arg);
});

window.consent = consent;
