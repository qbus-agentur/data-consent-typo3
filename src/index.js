import Cookie from 'cookie-universal'
import dialogPolyfill from 'dialog-polyfill'

var cookies = Cookie();
//var promise = new Promise()
var state = {
    functional: false,
    statistics: false,
    marketing: false
};
var acceptListeners = [];

export function isAccepted() {
    return new Promise(function(resolve, reject) {
        acceptListeners.push(resolve);
    });
};

export function launch() {
    // todo: read cookie
    //

    if (cookies.get('cookie-consent')) {
        state.functional = true;
        state.statistics = true;
        state.marketing = true;
        // Fire promise change

    } else {
        createDialog();
    }

    //alert('foo');
    //return new Promise(
    //);


};

function createDialog()
{
    var template = document.querySelector('#cookie-modal');
    var fragment = document.importNode(template.content, true);
    var dialog = fragment.querySelector('dialog');

    dialogPolyfill.registerDialog(dialog);

    dialog.querySelector('.data-consent-accept-all').addEventListener('change', function() {
        var checked = this.checked;
        dialog.querySelectorAll('input[type=checkbox]').forEach(function(el) {
            el.checked = checked;
        });
        dialog.querySelector('button[type=submit][value=accept-all]').setAttribute('data-selected', checked ? 'all' : 'some');

    });

    dialog.addEventListener('close', function() {
        switch (dialog.returnValue) {
        case 'accept-all':
            acceptListeners.forEach(function(resolve) {
                resolve(dialog.returnValue);
            });
            break;
        }
    });

    document.body.appendChild(fragment);
    dialog.showModal();
}
