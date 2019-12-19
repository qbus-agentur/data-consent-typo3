import Cookie from 'cookie-universal'
import dialogPolyfill from 'dialog-polyfill'
import Promise from 'es6-promise'

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
    var dialog = getDialogElement();

    dialog.querySelector('.data-consent-accept-all').addEventListener('change', function() {
        var checked = this.checked;
        Array.prototype.forEach.call(dialog.querySelectorAll('input[type=checkbox]'), function(el) {
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

    document.body.appendChild(dialog);
    dialog.showModal();
}

function getDialogElement()
{
    var template = document.querySelector('#cookie-modal');
    var dialog;
    if (template.content) {
        var fragment = document.importNode(template.content, true);
        dialog = fragment.querySelector('dialog');
    } else {
        var tmp = document.createElement('div') ;
        tmp.innerHTML = template.innerHTML;
        dialog = tmp.querySelector('dialog');
    }
    dialogPolyfill.registerDialog(dialog);

    return dialog;
}
