import DataConsent from '../src/index';

var consent = new DataConsent({
    banner: false,
    functional: false
});

consent.isAccepted().then(function(state) {
    console.log(JSON.stringify(state));
});
consent.isAccepted('essential').then(function(type) {
    console.log('Essential cookies have been enabled');
});
consent.isAccepted('marketing').then(function() {
    console.log('Marketing is enabled');
    //$('iframe[data-src]').attr('src', function() {
    //	return $(this).attr('data-src');
    //});
});

if (document.body.classList.contains('js-data-consent-privacy-page') === false) {
    consent.launch();
}
window.consent = consent;

Array.prototype.forEach.call(
    document.querySelectorAll('.js-data-consent-dialog-open'),
    function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            consent.forceOpen();
        });
    }
);

window.openConsent = function() {
	consent.forceOpen();
};



/* For demo purposes only */
var locationHashChanged = function() {
    var url = window.location.hash.substr(1)
    var iframe = document.querySelector('iframe.demo-iframe')
    if (!iframe) {
        return;
    }
    if (url) {
        if (!/^https?:\/\//i.test(url)) {
            url = 'https://' + url;
        }
        iframe.setAttribute('src', url);
    } else {
        iframe.removeAttribute('src');
    }
}
window.addEventListener("hashchange", locationHashChanged);
locationHashChanged();
