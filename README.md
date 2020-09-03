# Data Consent library based on Promises

This library is both a generic [JavaScript library](https://www.npmjs.com/package/@qbus/data-consent)
and a [TYPO3 integration](https://packagist.org/packages/qbus/data-consent).

## Installation

```bash
$ npm install --save @qbus/data-consent
# For composer TYPO3 installations:
$ composer require qbus/data-consent
# For classic mode TYPO3 installations:
$ git submodule add https://github.com/qbus-agentur/data-consent.git typo3conf/ext/data_consent
```

## Bundling CSS and JavaScript

### Usage with LESS

Add the following contents to your style.less file:

```less
@import (inline) "npm://@qbus/data-consent";
dialog.data-consent {
    --primary-color: #64c5e2;
    --btn-border-radius: 2em;
    --box-background: #ededed;
}
```

Adapt your less-css pipeline to include the `npm-import` plugin.

```bash
$ npm install --save-dev less-plugin-npm-import
$ lessc --npm-import style.less stlye.css
```


### Usage with browserify

To bundle `@qbus/data-consent` into a javascript bundle created with browserify,
the `esmify` plugin is required to support the ES6 module import/export syntax
used by `@qbus/data-consent`.

```bash
$ npm install --save-dev esmify
```

Add the following contents to your index.js file:

```js
import DataConsent from '@qbus/data-consent';

var consent = new DataConsent({
    banner: false,
    functional: false
});
consent.isAccepted('marketing').then(function(type) {
        $.getScript('https://www.googletagmanager.com/gtag/js?id=' + window.gatid);
});
consent.launch();
```

Adapt your browserify pipeline to include the `esmify` plugin.
The plugin will be enabled by passing `-p esmify` to the browserify command:


```bash
$ browserify -p esmify index.js -o bundle.js
```


### Usage with webpack

```js
import DataConsent from '@qbus/data-consent'
```

Webpack will bundle the `es6-promise` polyfill and `dialog-polyfill` automatically.
If you do *not* need support for IE11, you may exclude the `es6-promise` polyfill
from being bundled:

```js
// webpack.config.js
module.exports = {
  // …
  externals: {
    'es6-promise': 'Promise'
  }
}
```

## Pre-bundled JavaScript and CSS usage (hosted)

> :warning: HEADS UP
>
> To avoid transatlantic exchanges of personal data,
> you should not use unpkg.com as CDN in production.
> Use it for testing, but download the assets and host
> them directly for production.

Serve the file `data-content.css` and `data-content.js` from your server or include them from
[UNPKG](https://unpkg.com/@qbus/data-consent/).
You should include a `Promise` polyfill if you need support for Internet Explorer 11:

```html
<link rel="stylesheet" href="https://unpkg.com/@qbus/data-consent@0.2.2/data-consent.css">

<script src="https://unpkg.com/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script src="https://unpkg.com/@qbus/data-consent@0.2.2/data-consent.min.js"></script>
```

`DataConsent` is provided as global class by `data-consent` and can be instantiated with `new`:

```js
var consent = new DataConsent({
    banner: false,
    functional: false
});
consent.isAccepted('marketing').then(function(type) {
        $.getScript('https://www.googletagmanager.com/gtag/js?id=' + window.gatid);
});
consent.launch();
```

## Using third party storage backends

```js
import DataConsent from '@qbus/data-consent'
import Cookies from 'js-cookie'
var consent = new DataConsent({
    storage: Cookies.withAttributes({ path: '/', domain: '.example.com', expires: 3650, secure: true })
});
