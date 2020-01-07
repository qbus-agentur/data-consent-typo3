import Cookie from 'cookie-universal'
import dialogPolyfill from 'dialog-polyfill'
import Promise from 'es6-promise'

var cookies = Cookie();
//var promise = new Promise()
var state = {
    essential: false,
    functional: false,
    statistics: false,
    marketing: false
};

var acceptListeners = {
    essential: [],
    functional: [],
    statistics: [],
    marketing: [],
};

export function isAccepted(type) {
    return new Promise(function(resolve, reject) {
        acceptListeners[type].push(resolve);
    });
};

function firePromises(state) {
    Object.keys(acceptListeners).map(function(type, index) {
        if (state[type]) {
            acceptListeners[type].forEach(function(resolve) {
                resolve(type);
            });
        }
    });
}

function createDialog()
{
    var dialog = getDialogElement();

    dialog.querySelector('.data-consent-accept-all').addEventListener('change', function() {
        var checked = this.checked;
        Array.prototype.forEach.call(dialog.querySelectorAll('input[type=checkbox]'), function(el) {
            el.checked = checked;
        });
        dialog.querySelector('button[type=submit][value=accept]').setAttribute('data-selected', checked ? 'all' : 'some');

    });

    dialog.addEventListener('close', function() {
        switch (dialog.returnValue) {
        case 'accept':
            state = {
                essential: false,
                functional: false,
                statistics: false,
                marketing: false
            };
            Object.keys(acceptListeners).map(function(type, index) {
                var input = dialog.querySelector('input[type="checkbox"][value="' + type + '"]');
                if (input && input.checked) {
                    state[type] = true;
                }
            });
            cookies.set('cookie-consent', state);
            firePromises(state);
            break;
        }
    });

    document.body.appendChild(dialog);
    dialog.showModal();
}

export function launch() {
    state = cookies.get('cookie-consent');
    if (state) {
        firePromises(state);
    } else {
        createDialog();
    }
};

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
