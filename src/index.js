import Cookie from 'cookie-universal'
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
    var content =
        '  <dialog id="favDialog">' +
        '    <form method="dialog">' +
        '      <section>' +
        '        <svg viewBox="0 0 24 24">' +
        '          <path fill="currentColor" d="M12,3A9,9 0 0,0 3,12A9,9 0 0,0 12,21A9,9 0 0,0 21,12C21,11.5 20.96,11 20.87,10.5C20.6,10 20,10 20,10H18V9C18,8 17,8 17,8H15V7C15,6 14,6 14,6H13V4C13,3 12,3 12,3M9.5,6A1.5,1.5 0 0,1 11,7.5A1.5,1.5 0 0,1 9.5,9A1.5,1.5 0 0,1 8,7.5A1.5,1.5 0 0,1 9.5,6M6.5,10A1.5,1.5 0 0,1 8,11.5A1.5,1.5 0 0,1 6.5,13A1.5,1.5 0 0,1 5,11.5A1.5,1.5 0 0,1 6.5,10M11.5,11A1.5,1.5 0 0,1 13,12.5A1.5,1.5 0 0,1 11.5,14A1.5,1.5 0 0,1 10,12.5A1.5,1.5 0 0,1 11.5,11M16.5,13A1.5,1.5 0 0,1 18,14.5A1.5,1.5 0 0,1 16.5,16H16.5A1.5,1.5 0 0,1 15,14.5H15A1.5,1.5 0 0,1 16.5,13M11,16A1.5,1.5 0 0,1 12.5,17.5A1.5,1.5 0 0,1 11,19A1.5,1.5 0 0,1 9.5,17.5A1.5,1.5 0 0,1 11,16Z" />' +
        '        </svg>' +
        '        <h2>Datenschutz ist uns wichtig</h2>' +
        '        <p><label for="favAnimal">Favorite animal:</label>' +
        '        <select id="favAnimal" name="favAnimal">' +
        '          <option></option>' +
        '          <option>Brine shrimp</option>' +
        '          <option>Red panda</option>' +
        '          <option>Spider monkey</option>' +
        '        </select></p>' +
        '        <p>Our site is supported by advertising and we and our partners use technology such as cookies on our site to personalize content and ads, provide social media features, and analyze our traffic. Click "I Accept" below to consent to the use of this technology across the web. You can change your mind and change your consent choices at any time by returning to this site and clicking the Privacy Choices link.' +
        '        <p>By choosing I Accept below you are also helping to support our site and improve your browsing experience. </p>' +
        '      </section>' +
        '      <menu>' +
        '        <button type="submit" value="decline">Ablehnen</button>' +
        '        <button type="submit" value="accept-all">Einstellungen akzeptieren</button>' +
        '      </menu>' +
        '    </form>' +
        '  </dialog>';
    var container = document.createElement('div');
    container.setAttribute('class', 'data-consent');

    container.innerHTML = content;
    document.body.appendChild(container);

    var dialog = document.getElementById('favDialog');

    dialog.addEventListener('close', function() {
        switch (dialog.returnValue) {
        case 'accept-all':
            acceptListeners.forEach(function(resolve) {
                resolve(dialog.returnValue);
            });
            break;
        }
    });
    dialog.showModal();
}
